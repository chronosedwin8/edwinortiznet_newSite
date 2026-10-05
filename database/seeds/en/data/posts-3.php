<?php

declare(strict_types=1);

// English translations of Spanish tutorials (imported with needs_review = 1). Keys are the WordPress IDs of the Spanish source.
return [
    25 => [
        'slug' => 'how-to-create-qr-codes-that-never-expire',
        'title' => 'How to Create QR Codes That Never Expire',
        'excerpt' => 'How do you create QR codes that never expire? Some people think the question makes no sense, but expiring QR codes are real. Here I explain how to create QR codes with no expiry date, using a tool found on most computers in the world.',
        'seo_title' => 'How to Create QR Codes That Never Expire Using Excel',
        'seo_description' => 'Learn why some free QR codes expire and how to create QR codes that never expire using Excel, a tool you will find on most computers, plus a free Google API.',
        'focus_keyword' => 'QR codes that never expire',
        'content_html' => <<<'HTML'
<p>How do you create QR codes that never expire? For some people the question makes no sense, but expiring QR codes are real, and I am going to show you how to create them with no expiry date, using a tool found on most computers in the world.</p>

<p>How to create QR codes that never expire is a strange question, but many websites that offer free QR code creation don't tell you up front that the QR codes made on their site have an expiry date.</p>

<h2>Do QR codes really expire?</h2>

<p><strong>QR codes do not "expire".</strong></p>

<p>All a QR code does is hold a small piece of text. Usually that text is a website URL, and most phones and other mobile devices will scan a QR code and, if it contains a web address, go straight to it.</p>

<h2>How do expiring QR codes work?</h2>

<p>When we ask ourselves how to create QR codes that never expire, we need to understand that the codes that do expire are simply built with a different URL from the one you provided.</p>

<p>The process is very simple and is known as redirection. It relies on URL shorteners, which take one URL and replace it with another that has countless properties the creator can manage. One of those properties is the link's expiry date; others include the redirection itself and even visit counters.</p>

<p>An example of this service is the one Twitter uses: when we enter a URL, it is immediately converted into a new URL made up of Twitter's root domain followed by a unique series of numbers and letters. This makes it possible to track statistics for that link, in other words, the number of times people have visited the URL you provided.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/1.PNG" alt="How to create QR codes that never expire" loading="lazy" decoding="async"></figure>

<p>In the image above you can see how my blog's URL is replaced by one with Twitter's structure.</p>

<h2>How to create QR codes that never expire using Excel</h2>

<p>Excel is a very powerful tool, but it has no built-in feature for creating <a href="/realidad-aumentada/" target="_blank" rel="noreferrer noopener">QR</a> codes. That is why I am going to show you a solution: a function that can turn the information in Excel cells into a working QR graphic.</p>

<p>To create QR codes in Excel we need to use some Google tools that belong to the <a rel="noreferrer noopener" href="https://developers.google.com/chart/infographics/docs/qr_codes" target="_blank">Chart API for developers</a>, but this time we are going to use it to generate the graphic inside Excel.</p>

<p>Using the API is very easy; all you need is the following URL:</p>

<pre>http://chart.apis.google.com/chart?cht=qr&amp;chs=300x300&amp;chl= Edwin Ortiz</pre>

<p>Replace the characters after the equals sign (=), paste it into any browser and, as if by magic, you get a QR code ready to use. Below is a video (click the image) where I explain how to use it in detail.</p>

<figure class="lite-yt" data-yt="3yIej7eCt3g"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=3yIej7eCt3g" data-yt="3yIej7eCt3g"><img src="https://i.ytimg.com/vi/3yIej7eCt3g/hqdefault.jpg" alt="Video: How to Create QR Codes That Never Expire" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<h2>How to create QR codes that never expire using macros</h2>

<p>Sometimes we need to create <a href="/producto/generador-de-codigos-qr-masivos/" target="_blank" rel="noreferrer noopener">QR codes in bulk</a> to make product labels, ID cards and more, which will later be read with a phone and stored in another Excel sheet. For that we can use the following function, which works together with other Excel functions and, in the end, gives you QR codes in Excel as easily as using the most basic function.</p>

<p>Below you will find 3 templates from my shop, the explanatory video (click the image) on how to create QR codes in bulk in Excel, and the code used in the video.</p>

<p>{{productos:destacados}}</p>
HTML,
    ],
    667 => [
        'slug' => 'bulk-qr-code-generator-from-excel',
        'title' => 'Bulk QR Code Generator from Excel',
        'excerpt' => 'Discover a new way to generate QR codes: straight from Excel. The "Bulk QR Code Generator" turns your spreadsheet into a factory of instant connections, so you can forget manual processes and enjoy automated efficiency.',
        'seo_title' => 'Bulk QR Code Generator from Excel: VBA Macro Explained',
        'seo_description' => 'A bulk QR code generator built in Excel with VBA: see how the macro reads a list of codes, creates each QR code and saves it as a PNG image in a chosen folder.',
        'focus_keyword' => 'bulk QR code generator',
        'content_html' => <<<'HTML'
<p><strong>The bulk QR code generator is a tool that will help you a great deal when you need to produce QR codes in large quantities.</strong></p>

<p>Discover a new way to generate <a href="/codigos-qr-en-excel-como-crearlos/">QR codes: <em>straight from Excel</em></a>! The "Bulk QR Code Generator" turns your spreadsheet into a factory of instant connections. Forget manual processes and dive into automated efficiency. With just a few clicks, the digital world is within your reach.</p>

<figure class="lite-yt" data-yt="AYSyxxDq01M"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=AYSyxxDq01M" data-yt="AYSyxxDq01M"><img src="https://i.ytimg.com/vi/AYSyxxDq01M/hqdefault.jpg" alt="Video: Bulk QR Code Generator from Excel" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<hr>

<h3>If you would rather skip all the work, here is the link to buy the template</h3>

<h4><a href="/producto/generador-de-codigos-qr-masivos-a-imagenes-png/">Product</a></h4>

<hr>

<h2>How to build the macro for the bulk QR code generator</h2>

<p>As we saw in the video above, the macro reads a list of codes, serial numbers or whatever you like and turns them into QR codes, which are then saved in a folder chosen by the user.</p>

<p><strong><a href="https://youtu.be/CQKqDyUGdm4" target="_blank" rel="noreferrer noopener">Watch other related videos</a></strong></p>

<p>The first thing to look at is the <strong>GenerateAndSaveQRCodes</strong> macro. This routine is the heart of the whole process, so let's show it first and then break it down.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06134534/fun1.png" alt="Bulk QR code generator" width="991" height="529" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06134534/fun1-300x160.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06134534/fun1-600x320.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06134534/fun1-768x410.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06134534/fun1.png 991w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h4><strong>Start of the subroutine:</strong></h4>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135321/subru-1.png" alt="Bulk QR code generator from Excel" width="330" height="51" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135321/subru-1-300x46.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135321/subru-1.png 330w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>This line starts the definition of a subroutine called <code><strong>GenerateAndSaveQRCodes</strong></code>. A subroutine is a block of code that performs a specific task in VBA.</p>

<h4><strong>Variable declarations:</strong></h4>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135450/declara.png" alt="Bulk QR code generator" width="770" height="76" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135450/declara-300x30.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135450/declara-600x59.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135450/declara-768x76.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135450/declara.png 770w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>Here a variable <code><strong>ws</strong></code> of type <code><strong>Worksheet</strong></code> is declared and set to the worksheet that is active at that moment. The assumption is that this sheet holds the data that will be used to generate the QR codes.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135802/rcell.png" alt="Bulk QR code generator from Excel" width="409" height="152" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135802/rcell-300x111.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06135802/rcell.png 409w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>Another variable, <code><strong>rCell</strong></code>, is declared; it will be used to refer to each individual cell within a specified range of the worksheet.</p>

<h4><strong>Folder selection</strong></h4>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140025/selcarpeta.png" alt="VBA code for the QR code function" width="744" height="233" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140025/selcarpeta-300x94.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140025/selcarpeta-600x188.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140025/selcarpeta.png 744w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>This block of code lets the user choose the folder where the QR codes will be saved. If no folder is selected, an alert message is shown and the subroutine ends.</p>

<h4><strong>Loop to generate and save the QR codes</strong></h4>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar-1024x185.png" alt="Bulk QR codes" width="1024" height="185" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar-300x54.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar-600x108.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar-768x138.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar-1024x185.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140330/iterrar.png 1171w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>This <code><strong>For Each</strong></code> loop goes through every cell in column A, from A1 down to the last cell with data. For each non-empty cell, it takes the first 6 characters of the cell's value to build a file name for the QR code. It then calls another subroutine, <code><strong>SaveQRCodeAsPNG</strong></code>, which is not defined in this snippet (we will look at it next) and which generates a QR code image and saves it in the selected folder as a PNG file with a resolution of 300x300 pixels.</p>

<h2>Before we continue, a couple of recommendations on the topic</h2>

<p>{{articulos:excel}}</p>

<h2>How to generate the images in the bulk QR code generator</h2>

<p>Here we are going to look at the <strong>SaveQRCodeAsPNG</strong> function.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140943/saveqr.png" alt="Turning the data into QR codes" width="991" height="541" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140943/saveqr-300x164.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140943/saveqr-600x328.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140943/saveqr-768x419.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06140943/saveqr.png 991w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The <code><strong>SaveQRCodeAsPNG</strong></code> function is a VBA procedure designed to generate QR codes and save them as PNG images in a location specified by the user. Here are the most important parts of the code:</p>

<p><strong>Subroutine parameters:</strong></p>

<ul>
<li><code>sFileName</code>: path and name of the file where the QR code will be saved.</li>

<li><code>QR_Value</code>: value or text that will be converted into a QR code.</li>

<li><code>PictureSize</code>: size of the QR code image in pixels, with a default value of 300x300.</li>
</ul>

<p><strong>Building the Google API URL that generates the QR code:</strong></p>

<ul>
<li>It uses the Google Chart API to generate QR codes, building a URL with the required parameters such as the size (<code>chs</code>), the chart type (<code>cht=qr</code>) and the data to encode (<code>chl</code>).</li>
</ul>

<p><strong>URL encoding:</strong></p>

<ul>
<li>The <code><strong>UTF8_URL_Encode</strong></code> function (not shown here) is defined further down and takes care of properly encoding the value so it can be used in the URL, replacing spaces with the <code>+</code> sign.</li>
</ul>

<p><strong>HTTP request:</strong></p>

<ul>
<li>It creates an <code>XMLHTTP</code> object to send an HTTP GET request to the Google Chart service URL.</li>

<li>If the request succeeds (<code>oXMLHTTP.Status = 200</code>), it goes on to read the response.</li>
</ul>

<p><strong>Saving the file:</strong></p>

<ul>
<li>It uses an <code>ADODB.Stream</code> object to write the binary response (the QR code image) to a file with the specified name and path (<code>sFileName</code>).</li>

<li>The file is saved, overwriting any existing file with the same name.</li>
</ul>

<p><strong>Error handling:</strong></p>

<ul>
<li>If the HTTP status is not 200, it shows an error message with the status code and a description.</li>
</ul>

<p>The function is declared as <code>Private</code>, which means it can only be called from inside the module where it is defined.</p>

<p>This code is essential to how the macro works, because it turns the data into QR codes and saves them as images on the user's file system, making them easy to use in other documents, printouts or web applications.</p>

<h2>Encoding the QR data correctly</h2>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06141955/UTF8.png" alt="QR codes" width="572" height="393" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06141955/UTF8-300x206.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06141955/UTF8.png 572w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The <code><strong>UTF8_URL_Encode</strong></code> function is responsible for converting a text string (<code>sStr</code>) into a URL-safe format using UTF-8 encoding. The relevant parts of this function are described below:</p>

<p><strong>Variables:</strong></p>

<ul>
<li><code>i</code>: index used to iterate over each character in the string.</li>

<li><code>a</code>: stores the numeric value of the Unicode character code.</li>

<li><code>res</code>: resulting string that accumulates the URL-encoded version of <code>sStr</code>.</li>

<li><code>code</code>: temporary string that stores the encoded version of each individual character.</li>
</ul>

<p><strong>Encoding process:</strong></p>

<ol>
<li><strong>Iterating over each character</strong>: the <code>For</code> loop goes through each character of the input string.</li>

<li><strong>Getting the Unicode value</strong>: it uses <code>AscW</code> to get the Unicode value of each character. <code>AscW</code> returns the Unicode character value and can handle characters outside the standard ASCII range (0-127).</li>

<li><strong>Deciding whether encoding is needed</strong>:
<ul>
<li>If the value of <code>a</code> is less than 128, that is, a standard ASCII character, it is left as it is.</li>

<li>If the value is between 128 and 2047, the character falls within the range of extended Latin characters or other alphabets such as Greek or Cyrillic, and needs a two-byte UTF-8 encoding.</li>

<li>For higher values (characters with higher Unicode code points), three bytes are needed for the UTF-8 encoding.</li>
</ul>
</li>

<li><strong>Character encoding</strong>: bitwise operations are performed and then the <code><strong>URLEncodeByte</strong></code> function is called to convert each byte into its hexadecimal representation preceded by a percent sign (<code>%</code>), which is the format expected for URL encoding.</li>

<li><strong>Concatenating the encoded string</strong>: <code>res</code> accumulates the encoded result of each character.</li>
</ol>

<p>At the end of the function, <code><strong>UTF8_URL_Encode</strong></code> returns the complete string URL-encoded with UTF-8, which ensures that any character, whatever its linguistic or symbolic origin, can be transmitted correctly through URLs in web applications and APIs.</p>

<h2>A few secrets of the QR code generator</h2>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06142627/url.png" alt="Bulk QR code generator" width="647" height="133" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06142627/url-300x62.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06142627/url-600x123.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/11/06142627/url.png 647w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The <strong><code>URLEncodeByte</code> function</strong> plays an essential role in URL-encoding characters so they can be used in URLs, especially characters that are not standard ASCII. In the Excel macro you are using to generate QR codes, this function is a component of the <code>UTF8_URL_Encode</code> function. Here is how it works and how it connects with the rest of the code:</p>

<p><strong>Purpose of <code>URLEncodeByte</code>:</strong></p>

<ul>
<li>This function takes an integer value <code>val</code> that represents a byte (a number between 0 and 255) and converts it into its hexadecimal representation with a "%" prefix. This is because, in URL encoding, non-ASCII or reserved characters must be replaced by a percent sign followed by two hexadecimal digits representing the character's byte value.</li>
</ul>

<p><strong>How it works:</strong></p>

<ol>
<li>The function takes the integer value <code><strong>val</strong></code> and uses the <code><strong>Hex</strong></code> function to convert it into a string representing its hexadecimal equivalent.</li>

<li><code>Hex(val)</code> returns a hexadecimal string without leading zeros, so if the hexadecimal value is less than 16 (for example, <code>E</code> for the number 14), a zero is added at the start to make sure the result has two digits.</li>

<li><code>Right("0" &amp; Hex(val), 2)</code> ensures the result always has two characters, which is required for URL-encoding individual characters.</li>

<li>Finally, a "%" is added in front of these two characters, which is the syntax required for URL encoding.</li>
</ol>

<p><strong>Connection with other functions:</strong></p>

<ul>
<li><code><strong>URLEncodeByte</strong></code> is called by <code>UTF8_URL_Encode</code>, which is responsible for fully encoding a text string so it can be used safely in URLs.</li>

<li>In the UTF-8 encoding process, which may require one, two or three bytes depending on the original character, <code>URLEncodeByte</code> is used to convert each of those bytes into its percent-encoded format, which is then concatenated to form the final URL-encoded string.</li>
</ul>

<p><strong>Practical use:</strong></p>

<ul>
<li>When the macro builds a URL to create a <strong><a href="https://youtu.be/3yIej7eCt3g" target="_blank" rel="noreferrer noopener">QR code using the Google Chart API</a></strong>, any character that is not standard or URL-safe has to be encoded this way. <code><strong>URLEncodeByte</strong></code> makes sure each byte is encoded correctly so it can be sent in the request URL to the API.</li>
</ul>

<p>{{articulos:excel}}</p>
HTML,
    ],
    37 => [
        'slug' => 'what-you-need-to-know-about-barcodes-in-excel',
        'title' => 'What You Need to Know About Barcodes in Excel',
        'excerpt' => 'Barcodes in Excel are a form of encoding that identifies products and items so they can be counted and controlled correctly. Here you will learn the main barcode types and the steps to create them in Excel.',
        'seo_title' => 'What You Need to Know About Barcodes in Excel (+ Video)',
        'seo_description' => 'Barcodes in Excel help you identify products and items. Learn the steps to create them and how Code 39, Code 128, EAN 8, EAN 13 and UPC barcodes differ.',
        'focus_keyword' => 'barcodes in Excel',
        'content_html' => <<<'HTML'
<p>Barcodes in Excel are a form of encoding that identifies products and items so they can be counted and controlled correctly. The labels are printed using an electrostatic method (laser printing) on the front or back of the product or its packaging.</p>

<p>Barcodes in Excel are an advanced feature that lets you include barcodes for data and cross-references. Barcodes are commonly used to identify items in the commercial world, but they can also be useful for marking personal documents.</p>

<p>A barcode in Excel is a machine-readable optical label that contains information about the item it is attached to. The code consists of linear and/or two-dimensional graphic marks (symbols) that are attached to the product with adhesive labels or printed directly on it. Barcodes were first developed in 1948. As radio-frequency identification (RFID) technology became more widespread and affordable, companies began using RFID tags instead of barcodes. Barcodes in Excel and <a href="/codigos-qr-en-excel-como-crearlos/" target="_blank" rel="noreferrer noopener">QR codes</a> are now used for inventory control, where a reader is connected to a computer system and the item is recorded every time it is scanned.</p>

<p>Barcoding is a technology that uses a scanning system capable of digitising the quantities, weight and measurements of the products being labelled. Because scanning is so easy, barcoding has become a technology widely used in global trade.</p>

<h2>An in-depth look at the 3of9 barcode font and scanner</h2>

<p>The<a href="https://www.dafont.com/3of9-barcode.font" target="_blank" rel="noreferrer noopener"> 3of9 barcode</a> raster system was developed by Alexander Muir in the 1960s. The system was intended to let people encode binary data in a barcode that a computer could read. The barcode could then be decoded back into binary. The difference is that the bitmap image can be any size and the barcode can be any length; however, there is currently only one working example of a raster barcode that converts to 8-bit ASCII, which is 7-bit ASCII plus 1 bit for a new line.</p>

<h2>Steps to create barcodes in Excel</h2>

<figure class="lite-yt" data-yt="BZKpLKdepls"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=BZKpLKdepls" data-yt="BZKpLKdepls"><img src="https://i.ytimg.com/vi/BZKpLKdepls/hqdefault.jpg" alt="Video: What You Need to Know About Barcodes in Excel" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>With these three simple steps we can create our company's barcodes and customise them to our needs.</p>

<figure class="gallery"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+71%400.5x.png" alt="What you need to know about barcodes in Excel (1)" loading="lazy" decoding="async"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+72%400.5x.png" alt="What you need to know about barcodes in Excel (2)" loading="lazy" decoding="async"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+73%400.5x.png" alt="What you need to know about barcodes in Excel (3)" loading="lazy" decoding="async"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+74%400.5x.png" alt="What you need to know about barcodes in Excel (4)" loading="lazy" decoding="async"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+75%400.5x.png" alt="What you need to know about barcodes in Excel (5)" loading="lazy" decoding="async"><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/0.5x/CieloAzulArtboard+1+copy+76%400.5x.png" alt="What you need to know about barcodes in Excel (6)" loading="lazy" decoding="async"></figure>

<hr>

<h2>Barcode characteristics</h2>

<h3>Code 39</h3>

<p>Also known as <strong>Code 3 of 9</strong>, it is an <strong>alphanumeric</strong>, variable-length barcode. It lets you generate a barcode that includes numbers, capital letters and some special characters such as spaces, hyphens and slashes.</p>

<h3>Code 128</h3>

<p>It is a barcode similar to <strong>Code 3 of 9</strong>, with the difference that it includes a check digit (checksum) to make reading the code more reliable. Now called <strong>GS1-128</strong> (formerly <a href="http://es.wikipedia.org/wiki/GS1-128" target="_blank" rel="noreferrer noopener">EAN 128</a>), it can encode alphanumeric characters plus ASCII control characters such as CR, LF, etc. It is mainly used in logistics and parcel delivery (courier services).</p>

<h3>EAN 8 / EAN 13</h3>

<p>These are two types of <strong>numeric </strong><strong>barcodes</strong> used in Europe (they do not accept letters). <strong>EAN</strong> stands for European Article Number, and their main use is to encode retail items (mainly the products you find in supermarkets).</p>

<p>Their length is fixed at <strong>8</strong> and <strong>13</strong> digits respectively, and the last digit is a check digit (checksum). In an <strong>EAN13</strong> code, the first 3 digits identify the country of origin, the next four to five digits identify the manufacturer, and the remaining digits identify the product.</p>

<h3>UPC</h3>

<p>The <strong>UPC</strong> (Universal Product Code) is the counterpart of EAN 13, but used in the United States and Canada. It is numeric and is mainly used to encode products. There are two variants: UPC-A and UPC-E.</p>

<h2>Examples of different barcodes</h2>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/codigosbarras/codigo+barras.PNG" alt="Barcodes in Excel" loading="lazy" decoding="async"></figure>
HTML,
    ],
    35 => [
        'slug' => 'convert-numbers-to-words-in-excel-with-macros',
        'title' => 'Convert Numbers to Words in Excel with Macros',
        'excerpt' => 'Converting numbers to words in Excel is a feature every Excel user wishes were built in, but unfortunately it takes a little extra work. Here is how to do it with a VBA macro that writes amounts out in Spanish.',
        'seo_title' => 'Convert Numbers to Words in Excel with Macros (VBA)',
        'seo_description' => 'Convert numbers to words in Excel with a VBA macro: write out amounts in Spanish with a specific currency and cents. Use the ready-made module or the full code.',
        'focus_keyword' => 'convert numbers to words in Excel',
        'content_html' => <<<'HTML'
<p>Converting numbers to words in Excel is a feature that everyone who has used Excel wishes were available out of the box, but unfortunately it takes a little extra work to make that dream come true.</p>

<p>To make it happen we need to use the <a href="http://bit.ly/2ItFUN8" target="_blank" rel="noreferrer noopener">macro language</a>, Visual Basic for Applications (VBA). This language lets us add a new function that converts the number or amount in a cell into words (written in Spanish) with a specific currency, and we can even include cents for currencies that need them.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/CONVNUME.PNG" alt="Convert numbers to words in Excel" width="798" height="164" loading="lazy" decoding="async"></figure>

<h2>What we need to convert numbers to words in Excel</h2>

<p>To solve the problem of converting numbers to words in Excel there are two routes. The first is the quickest and most reliable: buy the module with all the content from <a href="/producto/convertidor-de-numeros-a-letras-en-excel/" target="_blank" rel="noreferrer noopener">the shop</a>, and then just follow the steps shown in the video below.</p>

<p>The second route, which I find interesting and quite educational, is to copy the lines of code needed to build this macro. I have included all of that content in this post so you can do it yourself and learn along the way.</p>

<h2>Option 1: Convert using the amount-in-words module</h2>

<p>As I mentioned, with this option you only need to buy the module with all the instructions ready to use in your Excel workbooks, and you will be able to convert numbers to words in any sheet or workbook in Excel 2013 or later.</p>

<a href="/producto/convertidor-de-numeros-a-letras-en-excel/">Buy now</a>

<h2>Video: Convert numbers to words in Excel</h2>

<figure class="lite-yt" data-yt="WnZ5qmvbZsw"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=WnZ5qmvbZsw" data-yt="WnZ5qmvbZsw"><img src="https://i.ytimg.com/vi/WnZ5qmvbZsw/hqdefault.jpg" alt="Video: Convert Numbers to Words in Excel with Macros" width="480" height="360"><span class="lite-yt__play"></span></a></figure>

<hr>

<h2>Option 2: Macro code to convert numbers</h2>

<p>Below is all the macro code so you can recreate this new number-conversion function in Excel and, if you have the experience and knowledge, modify any part of the code.</p>

<h3>Steps</h3>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/C1.PNG" alt="Macro code to convert numbers to words" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/C2.PNG" alt="Convert numbers to words in Excel with macros" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/C3.PNG" alt="Convert numbers to words in Excel with macros" loading="lazy" decoding="async"></figure>

<h2>How to use the CONVERTIRNUM() function in Excel workbooks</h2>

<p>The first thing you need to do is insert the module with the macro code, or write it yourself. Then just select a cell and call the CONVERTIRNUM() function. Keep in mind that the result is written out in Spanish words, since that is what this macro produces.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/Asistente.PNG" alt="Convert numbers to words in Excel with macros" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/img/factura+con+ejemplo.PNG" alt="Convert numbers to words in Excel with macros" loading="lazy" decoding="async"></figure>
HTML,
    ],
];
