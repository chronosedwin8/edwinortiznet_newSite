<?php

declare(strict_types=1);

// Artículo de análisis: «¿Excel está muerto en la era de la IA?». Datos de empleo (O*NET/Lightcast, WEF,
// Work Trend Index), mipymes (DANE EMICRON, Confecámaras, CEPAL, Eurostat), precios de Microsoft 365, Power BI
// y Copilot, y errores célebres con hojas de cálculo, verificados el 9 de octubre de 2026 con fuentes enlazadas.
// Las fórmulas en español, la macro VBA, la consulta de Power Query y las medidas DAX se probaron en Excel 16
// (Windows con configuración regional de Colombia). El texto va en nowdoc para que el código ($, <, &) no se
// interprete; los bloques <pre><code> se escapan automáticamente y las figuras se insertan con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/excel-muerto-ia/' . $name;
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
<p>Cada cierto tiempo alguien publica el obituario de Excel. Primero lo iban a matar las bases de datos, luego Python, después Power BI, y ahora la inteligencia artificial: «¿para qué aprender fórmulas si le pides a la IA que lo haga?». Excel cumplió <a href="https://techcommunity.microsoft.com/blog/excelblog/excel-turns-40-join-the-celebration/4438765" target="_blank" rel="noopener">40 años el 30 de septiembre de 2025</a> y, según el propio equipo de Microsoft, lo usan <a href="https://techcommunity.microsoft.com/blog/excelblog/excel-in-2025-a-year-of-culture-craft-and-copilot/4474245" target="_blank" rel="noopener">cientos de millones de personas</a>. Llevo más de veinte años enseñando matemáticas y programando en Excel y VBA para empresas y colegios, y mi respuesta es incómoda: <strong>Excel no está muerto en la era de la IA; lo que está muriendo es una forma de usarlo</strong>. La del profesional que copia, pega, arma el mismo informe cada lunes y nunca aprendió qué hay más allá de BUSCARV.</p>
<p>En este artículo te muestro los datos (empleo, pymes, costos), la pila moderna de Excel que casi nadie aprovecha, dónde Excel no es la herramienta correcta y cómo cambia el trabajo cuando la IA escribe las fórmulas. Y, como siempre, te dejo ejemplos para copiar y pegar: fórmulas en español, Power Query, DAX, una macro VBA, un Office Script, Python y prompts para Copilot, todos probados.</p>

<h2>¿Excel está muerto? Lo que dicen los datos</h2>
<p>Empecemos por el mercado laboral. O*NET, el sistema de información ocupacional del Departamento de Trabajo de Estados Unidos, publica con datos de Lightcast las tecnologías más pedidas en avisos de empleo. Entre el 1 de enero y el 31 de diciembre de 2025, de 46,9 millones de avisos únicos, <a href="https://www.onetonline.org/search/hot_tech/" target="_blank" rel="noopener">Microsoft Excel aparece en 3.211.598</a>: es la segunda tecnología más pedida, solo detrás del paquete Office en general. Python aparece en 814.960 avisos, SQL en 758.250 y Power BI en 357.898. Excel solo supera la suma de los tres. No es un fenómeno nuevo: en 2015, el estudio <a href="https://apo.org.au/node/209156" target="_blank" rel="noopener"><em>Crunched by the Numbers</em> de Burning Glass</a> encontró que la hoja de cálculo y el procesador de texto ya eran un requisito básico en el 78 % de los empleos de habilidades medias.</p>
<p>Ahora, la otra cara. El <a href="https://reports.weforum.org/docs/WEF_Future_of_Jobs_Report_2025.pdf" target="_blank" rel="noopener">informe Future of Jobs 2025 del Foro Económico Mundial</a> calcula que el 39 % de las habilidades actuales cambiará o quedará desactualizado entre 2025 y 2030; en Colombia, la cifra estimada es del 44 %, de las más altas entre las 55 economías estudiadas. El pensamiento analítico sigue siendo la habilidad central (siete de cada diez empresas la consideran esencial) y las de más rápido crecimiento son la IA y los grandes datos, las redes y la ciberseguridad, y la alfabetización tecnológica. El <a href="https://www.microsoft.com/en-us/worklab/work-trend-index/ai-at-work-is-here-now-comes-the-hard-part" target="_blank" rel="noopener">Work Trend Index 2024 de Microsoft y LinkedIn</a> añade que el 75 % de los trabajadores del conocimiento ya usa IA y que el 66 % de los líderes no contrataría a alguien sin habilidades de IA.</p>
<p>¿Y en Colombia? Busqué una cifra seria del porcentaje de vacantes que piden Excel y no la encontré; prefiero decirlo a inventarla. Lo que sí hay son datos contundentes sobre las empresas. Según el <a href="https://www.dane.gov.co/files/operaciones/EMICRON/bol-EMICRON-2024.pdf" target="_blank" rel="noopener">DANE (EMICRON 2024)</a>, en el país hay 5,3 millones de micronegocios: el 68,2 % no lleva ningún registro contable, el 27,1 % lleva cuentas informales «en un cuaderno, hoja de Excel o máquina registradora» y solo el 4,7 % usa un método contable formal. Apenas el 10,9 % usó un computador, tableta o portátil para su actividad. <a href="https://confecamaras.org.co/wp-content/uploads/2026/03/graficas-investigaciones-economicas-2025-v-2026-1.webp" target="_blank" rel="noopener">Confecámaras</a> reporta que, al cierre de 2025, el 99,5 % de las 1.805.564 empresas del país eran mipymes, y el <a href="https://www.mincit.gov.co/prensa/noticias/industria/celebracion-del-dia-de-las-mipymes" target="_blank" rel="noopener">MinCIT</a> estima que generan más del 78 % del empleo.</p>
<p>En América Latina, la <a href="https://www.cepal.org/es/temas/micro-pequenas-medianas-empresas-mipyme/acerca-microempresas-pymes" target="_blank" rel="noopener">CEPAL</a> señala que las mipymes son cerca del 99 % de las empresas y emplean alrededor del 67 % de los trabajadores, pero que las grandes empresas pueden ser hasta 33 veces más productivas que las microempresas; en los países de la OCDE esa brecha va de 1,3 a 2,4 veces. Incluso en Europa la distancia en análisis de datos es enorme: según <a href="https://ec.europa.eu/eurostat/databrowser/view/isoc_eb_das/default/table?lang=en" target="_blank" rel="noopener">Eurostat</a>, en 2025 el 35,1 % de las empresas pequeñas (10 a 49 empleados) analizaba datos, frente al 82,0 % de las grandes.</p>
{{img:datos}}
<p>Mi lectura: el mercado no abandona Excel; deja de pagar por el Excel básico. Y la pyme latinoamericana no tiene un problema de «Excel viejo», sino de no medir: para un micronegocio que anota en un cuaderno, una tabla bien hecha con una tabla dinámica ya es transformación digital.</p>

<h2>Lo que sí murió: el Excel de copiar y pegar</h2>
<p>Te propongo un examen rápido. Si te reconoces en tres o más de estas costumbres, tu forma de usar Excel está en riesgo, aunque Excel no lo esté:</p>
<ul>
<li>Cada mes abres doce archivos, copias sus datos y los pegas uno debajo del otro.</li>
<li>Usas BUSCARV contando columnas a mano y, si alguien inserta una columna, todo se rompe.</li>
<li>Tus informes tienen totales escritos a mano «porque la fórmula no daba».</li>
<li>Haces el mismo informe cada semana con los mismos clics, en el mismo orden.</li>
<li>No sabes qué es una tabla de Excel (Ctrl+T), Power Query ni una medida.</li>
<li>Pegas la fórmula que te dio la IA y, si da un número, la das por buena.</li>
</ul>
<p>El último punto es el más peligroso de 2026: la IA automatiza primero el trabajo mecánico, pero no el criterio para saber si el número tiene sentido. Lo desarrollé en <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">La IA no te va a reemplazar. Quien la domine, sí</a>, y aquí aplica literalmente.</p>

<h2>La pila moderna de Excel: mucho más que una cuadrícula</h2>
<p>El Excel de hoy es una cadena completa: conecta, limpia, modela, presenta y automatiza, con IA en cada paso. Este es el mapa:</p>
{{img:pila}}

<h3>Fórmulas dinámicas: BUSCARX, FILTRAR, UNICOS, AGRUPARPOR y LAMBDA</h3>
<p>Desde Microsoft 365 (y en buena parte desde Excel 2021), una fórmula puede devolver una tabla entera que se «desborda» sola. Supón una tabla <em>Ventas</em> con las columnas Fecha, Vendedor, Cliente, Ciudad, Producto, Categoría, Unidades y Total, y una tabla <em>Clientes</em>. Estas fórmulas las probé en Excel en español con punto y coma como separador; entre paréntesis te dejo el nombre en inglés:</p>
<pre><code>1) BUSCARX (XLOOKUP): trae el nombre del cliente sin contar columnas
=BUSCARX([@Cliente]; Clientes[Código]; Clientes[Nombre]; "No existe")

2) AGRUPARPOR (GROUPBY): total por vendedor, de mayor a menor, con total general
=AGRUPARPOR(Ventas[Vendedor]; Ventas[Total]; SUMA; ; ; -2)

3) PIVOTARPOR (PIVOTBY): categorías en filas y meses (202601, 202602...) en columnas
=PIVOTARPOR(Ventas[Categoría]; AÑO(Ventas[Fecha]) * 100 + MES(Ventas[Fecha]); Ventas[Total]; SUMA)

4) FILTRAR + ORDENARPOR (FILTER, SORTBY): ventas de Bogotá mayores a 1 millón
=ORDENARPOR(FILTRAR(Ventas; (Ventas[Ciudad] = "Bogotá") * (Ventas[Total] > 1000000); "Sin datos");
            FILTRAR(Ventas[Total]; (Ventas[Ciudad] = "Bogotá") * (Ventas[Total] > 1000000)); -1)

5) UNICOS (UNIQUE): cuántos clientes distintos atendió Ana
=CONTARA(UNICOS(FILTRAR(Ventas[Cliente]; Ventas[Vendedor] = "Ana")))

6) LET (LET): ranking legible con nombres intermedios
=LET(v; UNICOS(Ventas[Vendedor]);
     t; SUMAR.SI(Ventas[Vendedor]; v; Ventas[Total]);
     ORDENARPOR(APILARH(v; t); t; -1))

7) DIVIDIRTEXTO (TEXTSPLIT): separa un código de producto "CAM-AZU-M"
=DIVIDIRTEXTO(A2; "-")                     → CAM | AZU | M

8) Expresiones regulares (REGEXEXTRACT, REGEXTEST, REGEXREPLACE)
=REGEXEXTRACCION(A2; "[\w.+-]+@[\w-]+(\.[\w-]+)+")   → extrae el correo de un texto
=REGEXPRUEBA(B2; "^3\d{9}$")                          → ¿es un celular colombiano válido?
=REGEXREEMPLAZAR(C2; "\D"; "")                        → "(310) 456-78 90" queda 3104567890</code></pre>
<p>Fíjate en la fórmula 3. Si le pides a una IA «ventas por mes», casi siempre te propone <code>TEXTO(Ventas[Fecha]; "aaaa-mm")</code>. Lo probé en un Windows con configuración regional de Colombia y el resultado fue «jueves-03»: ahí, «aaaa» es el nombre del día y el año se escribe «yyyy». Por eso prefiero <code>AÑO()*100+MES()</code>, que funciona igual en cualquier idioma. Es un ejemplo perfecto de por qué una fórmula que «se ve bien» hay que comprobarla.</p>
<p>La joya es <strong>LAMBDA</strong>: te permite crear tus propias funciones sin una línea de VBA. En <em>Fórmulas &gt; Administrador de nombres &gt; Nuevo</em>, crea el nombre <em>COMISION</em> con esta definición:</p>
<pre><code>Nombre: COMISION
Hace referencia a:
=LAMBDA(venta; meta;
    LET(cumpl; venta / meta;
        SI(cumpl >= 1; venta * 5%;
           SI(cumpl >= 0,8; venta * 3%; 0))))

Uso en cualquier celda del libro:
=COMISION([@Total]; [@Meta])       → 12.000.000 con meta 10.000.000 = 600.000
                                     8.500.000 con meta 10.000.000 = 255.000</code></pre>
<p>Si mañana cambia la política de comisiones, la corriges en un solo lugar y todo el libro se actualiza. Eso es pensar como programador sin dejar de ser usuario de Excel. Si quieres ir más lejos, en <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial: ejemplos prácticos</a> tienes más funciones LAMBDA para analistas.</p>

<h3>Power Query: limpiar miles de filas sin una sola fórmula</h3>
<p>Power Query es la herramienta que más horas devuelve y la menos conocida. Se conecta a archivos, carpetas, bases SQL, SharePoint o la web, registra cada paso de limpieza y el mes siguiente solo pulsas <em>Actualizar todo</em>. El caso clásico: cada sede envía su archivo con los productos en filas y los meses en columnas. En la interfaz:</p>
<ol>
<li><em>Datos &gt; Obtener datos &gt; De un archivo &gt; Desde una carpeta</em>, elige la carpeta y pulsa <em>Transformar datos</em>.</li>
<li>Filtra la extensión .xlsx y combina los archivos tomando la primera hoja.</li>
<li>Agrega la columna Sede a partir del nombre del archivo.</li>
<li>Quita filas vacías, recorta espacios y pon los nombres en formato de título.</li>
<li>Selecciona Sede y Producto, y elige <em>Anular dinamización de otras columnas</em>: los meses pasan a filas.</li>
<li><em>Cerrar y cargar</em> en una tabla o directamente en el modelo de datos.</li>
</ol>
<p>Y este es el código M completo. Pégalo en <em>Obtener datos &gt; Desde otras fuentes &gt; Consulta en blanco &gt; Editor avanzado</em> y cambia la ruta:</p>
<pre><code>let
    // 1) Todos los archivos de la carpeta (uno por sede: "Norte.xlsx", "Centro.xlsx"...)
    Origen = Folder.Files("C:\Ventas\Sedes"),
    Libros = Table.SelectRows(Origen, each [Extension] = ".xlsx"
                 and not Text.StartsWith([Name], "~$")),

    // 2) De cada libro, la primera hoja con la fila 1 como encabezados,
    //    más una columna Sede tomada del nombre del archivo
    ConDatos = Table.AddColumn(Libros, "Datos", each
        let
            sede = Text.BeforeDelimiter([Name], "."),
            hojas = Table.SelectRows(Excel.Workbook([Content], true), each [Kind] = "Sheet"),
            hoja = hojas{0}[Data]
        in
            Table.AddColumn(hoja, "Sede", each sede, type text)),
    Combinado = Table.Combine(ConDatos[Datos]),

    // 3) Limpieza: sin filas vacías, sin espacios sobrantes, nombres uniformes
    SinVacias = Table.SelectRows(Combinado, each [Producto] <> null
                    and Text.Trim(Text.From([Producto])) <> ""),
    Limpio = Table.TransformColumns(SinVacias,
                 {{"Producto", each Text.Proper(Text.Trim(Text.From(_))), type text}}),

    // 4) Anular dinamización: los meses pasan de columnas a filas
    Filas = Table.UnpivotOtherColumns(Limpio, {"Sede", "Producto"}, "Mes", "Ventas"),
    Tipos = Table.TransformColumnTypes(Filas, {{"Ventas", type number}}, "es-CO"),
    SinErrores = Table.RemoveRowsWithErrors(Tipos, {"Ventas"}),
    Final = Table.SelectRows(SinErrores, each [Ventas] <> null and [Ventas] <> 0)
in
    Final</code></pre>
<p>Lo probé con tres archivos «sucios» (espacios, mayúsculas, filas vacías y un «n/d» donde iba un número) y devolvió una tabla limpia con Producto, Sede, Mes y Ventas. Un consejo de auditoría: el paso <em>SinErrores</em> descarta lo que no es número; revisa cuántas filas elimina, porque un «n/d» puede ser un dato que alguien olvidó reportar.</p>

<h3>Power Pivot y DAX: tu pequeño BI en casa</h3>
<p>El modelo de datos relaciona varias tablas como una base de datos y calcula indicadores con DAX, el mismo lenguaje de Power BI. Con una tabla <em>Calendario</em> (una fila por día) y otra de <em>Productos</em> relacionadas con <em>Ventas</em>, estas medidas cubren casi todo lo que pide un gerente:</p>
<pre><code>Ventas Totales := SUM ( Ventas[Total] )

Costo Total := SUMX ( Ventas, Ventas[Unidades] * RELATED ( Productos[Costo] ) )

Margen % := DIVIDE ( [Ventas Totales] - [Costo Total], [Ventas Totales] )

Ventas Año Anterior := CALCULATE ( [Ventas Totales], SAMEPERIODLASTYEAR ( Calendario[Fecha] ) )

Variación % Anual := DIVIDE ( [Ventas Totales] - [Ventas Año Anterior], [Ventas Año Anterior] )

Acumulado del Año := TOTALYTD ( [Ventas Totales], Calendario[Fecha] )

Acumulado Histórico :=
CALCULATE (
    [Ventas Totales],
    FILTER ( ALL ( Calendario[Fecha] ), Calendario[Fecha] <= MAX ( Calendario[Fecha] ) )
)</code></pre>
<p>Las verifiqué en un modelo de prueba contra cálculos a mano: margen del 43,75 %, variación de junio de +7,5 % y acumulados exactos. Y el modelo me dejó una lección: para todo 2026 la variación daba −46 %, porque 2026 solo tenía datos hasta junio y se comparaba con el 2025 completo. El DAX estaba bien; la pregunta, mal planteada. Las funciones DAX no se traducen, y si Power Pivot rechaza la coma entre argumentos en tu configuración regional, usa punto y coma.</p>

<h3>Tablas dinámicas avanzadas: lo que impresiona a un director</h3>
<p>Sobre ese modelo, una tabla dinámica se vuelve un tablero: segmentaciones por vendedor y ciudad, una escala de tiempo para elegir meses con el mouse, <em>Mostrar valores como &gt; % del total de la fila</em> para ver la mezcla de productos, y la medida <em>Variación % Anual</em> con formato condicional. Si conectas varias tablas dinámicas a las mismas segmentaciones (<em>Conexiones de informe</em>), tienes un tablero interactivo sin pagar una licencia adicional. Tengo una guía paso a paso en <a href="/tablas-dinamicas-en-excel-analiza-datos-como-un-profesional/">Tablas dinámicas en Excel: analiza datos como un profesional</a>.</p>

<h3>VBA y Office Scripts: automatizar lo que haces cada semana</h3>
<p>VBA tiene más de 30 años y sigue siendo la forma más directa de automatizar Excel de escritorio en Windows. Esta macro toma la hoja <em>Ventas</em>, genera un PDF por vendedor en una carpeta con la fecha y, si lo activas, deja listo un correo de Outlook con cada PDF adjunto. La probé con datos de ejemplo: tres vendedores, tres PDF, sin hojas temporales sobrantes ni filtros olvidados.</p>
<pre><code>Option Explicit

' Divide la hoja "Ventas" en un PDF por vendedor y, si quieres, deja
' listo un correo de Outlook con cada PDF adjunto (lo muestra, no lo envía).
' Requisitos: datos desde A1 con encabezados; una hoja "Correos" con
' Vendedor en la columna A y correo en la columna B (solo si ENVIAR = True).

Private Const HOJA_DATOS As String = "Ventas"
Private Const COL_VENDEDOR As Long = 2          ' B = Vendedor
Private Const ENVIAR As Boolean = False         ' True = preparar correos

Public Sub GenerarPDFPorVendedor()
    Dim ws As Worksheet, tmp As Worksheet
    Dim datos As Range, celda As Range
    Dim lista As Object, v As Variant
    Dim carpeta As String, archivo As String, n As Long

    Set ws = ThisWorkbook.Worksheets(HOJA_DATOS)
    If ws.AutoFilterMode Then ws.AutoFilterMode = False
    Set datos = ws.Range("A1").CurrentRegion
    If datos.Rows.Count < 2 Then
        MsgBox "La hoja " & HOJA_DATOS & " no tiene datos.", vbExclamation
        Exit Sub
    End If

    ' Carpeta de salida junto al libro: PDF_2026-10-09
    carpeta = ThisWorkbook.Path & Application.PathSeparator & "PDF_" & Format(Date, "yyyy-mm-dd")
    If Dir(carpeta, vbDirectory) = "" Then MkDir carpeta

    ' Vendedores sin repetir (sin distinguir mayúsculas)
    Set lista = CreateObject("Scripting.Dictionary")
    lista.CompareMode = vbTextCompare
    For Each celda In datos.Columns(COL_VENDEDOR).Offset(1).Resize(datos.Rows.Count - 1).Cells
        If Len(Trim$(CStr(celda.Value))) > 0 Then lista(Trim$(CStr(celda.Value))) = True
    Next celda

    Application.ScreenUpdating = False
    On Error GoTo Fallo
    For Each v In lista.Keys
        ' Filtra el vendedor y copia solo las filas visibles a una hoja temporal
        datos.AutoFilter Field:=COL_VENDEDOR, Criteria1:="=" & v
        Set tmp = ThisWorkbook.Worksheets.Add(After:=ws)
        datos.SpecialCells(xlCellTypeVisible).Copy tmp.Range("A1")
        tmp.Columns.AutoFit
        With tmp.PageSetup
            .Orientation = xlLandscape
            .Zoom = False
            .FitToPagesWide = 1
            .FitToPagesTall = False
            .CenterHeader = "Ventas de " & v
            .RightFooter = "Página &P de &N"
        End With
        archivo = carpeta & Application.PathSeparator & NombreSeguro(CStr(v)) & ".pdf"
        tmp.ExportAsFixedFormat Type:=xlTypePDF, Filename:=archivo, OpenAfterPublish:=False
        Application.DisplayAlerts = False
        tmp.Delete
        Application.DisplayAlerts = True
        Set tmp = Nothing
        If ENVIAR Then PrepararCorreo CStr(v), archivo
        n = n + 1
    Next v

Fallo:
    ' Pase lo que pase: quita el filtro, borra la hoja temporal y restaura la pantalla
    If Not tmp Is Nothing Then
        Application.DisplayAlerts = False
        tmp.Delete
        Application.DisplayAlerts = True
    End If
    If ws.AutoFilterMode Then ws.AutoFilterMode = False
    Application.ScreenUpdating = True
    If Err.Number <> 0 Then
        MsgBox "Error con " & v & ": " & Err.Description, vbCritical
    Else
        MsgBox n & " PDF guardados en:" & vbLf & carpeta, vbInformation
    End If
End Sub

' Crea un correo de Outlook con el PDF adjunto y lo muestra para revisarlo.
Private Sub PrepararCorreo(ByVal vendedor As String, ByVal archivo As String)
    Dim correo As Variant, ol As Object, msg As Object
    correo = Application.VLookup(vendedor, ThisWorkbook.Worksheets("Correos").Range("A:B"), 2, False)
    If IsError(correo) Then Exit Sub                  ' sin correo registrado: no se prepara
    Set ol = CreateObject("Outlook.Application")
    Set msg = ol.CreateItem(0)
    With msg
        .To = correo
        .Subject = "Tu reporte de ventas - " & Format(Date, "mmmm yyyy")
        .Body = "Hola, " & vendedor & ":" & vbLf & vbLf & _
                "Adjunto tu reporte de ventas. Cualquier diferencia, me cuentas." & vbLf
        .Attachments.Add archivo
        .Display                                       ' cambia a .Send cuando confíes en el proceso
    End With
End Sub

' Quita los caracteres que Windows no acepta en un nombre de archivo.
Private Function NombreSeguro(ByVal s As String) As String
    Dim c As Variant
    For Each c In Array("\", "/", ":", "*", "?", """", "<", ">", "|")
        s = Replace(s, c, "_")
    Next c
    NombreSeguro = Left$(Trim$(s), 100)
End Function</code></pre>
<p>Para usarla: <em>Alt+F11 &gt; Insertar &gt; Módulo</em>, pega el código, guarda como <em>.xlsm</em> y ejecútala con <em>Alt+F8</em>. Los correos se muestran sin enviarse, los errores no dejan filtros puestos y los nombres de archivo se limpian. Si necesitas lo mismo con plantillas de Word, cientos de destinatarios, copias CC y CCO o adjuntos por persona, ya lo resolví en dos plantillas: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Enviar correos masivos con adjuntos y copias CC y CCO</a> y <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Combinar correspondencia y generar PDF individuales</a>.</p>
<p>La versión moderna son los <strong>Office Scripts</strong> (TypeScript, pestaña <em>Automatizar</em>), para Excel en la web, Windows y Mac con licencias empresariales o educativas. Su ventaja es que se conectan con <strong>Power Automate</strong>: según la <a href="https://learn.microsoft.com/en-us/office/dev/scripts/testing/platform-limits" target="_blank" rel="noopener">documentación de Microsoft</a>, la acción <em>Ejecutar script</em> admite hasta 1.600 llamadas por usuario al día, con un tiempo máximo de 120 segundos por ejecución. Este script rehace una hoja <em>Resumen</em> con el total por vendedor y devuelve un texto para un correo:</p>
<pre><code>function main(workbook: ExcelScript.Workbook): string {
  const tabla = workbook.getTable("Ventas");
  if (!tabla) {
    throw new Error("No encontré la tabla Ventas");
  }
  const encabezados = tabla.getHeaderRowRange().getValues()[0] as string[];
  const iVendedor = encabezados.indexOf("Vendedor");
  const iTotal = encabezados.indexOf("Total");

  // Suma el total de cada vendedor
  const totales = new Map<string, number>();
  for (const fila of tabla.getRangeBetweenHeaderAndTotal().getValues()) {
    const vendedor = String(fila[iVendedor]).trim();
    totales.set(vendedor, (totales.get(vendedor) || 0) + Number(fila[iTotal]));
  }
  const filas = Array.from(totales.entries()).sort((a, b) => b[1] - a[1]);
  if (filas.length === 0) {
    return "La tabla Ventas está vacía";
  }

  // Rehace la hoja Resumen en cada ejecución
  workbook.getWorksheet("Resumen")?.delete();
  const hoja = workbook.addWorksheet("Resumen");
  hoja.getRange("A1:B1").setValues([["Vendedor", "Total"]]);
  hoja.getRange("A1:B1").getFormat().getFont().setBold(true);
  hoja.getRangeByIndexes(1, 0, filas.length, 2).setValues(filas);
  hoja.getRangeByIndexes(1, 1, filas.length, 1).setNumberFormat("$#,##0");
  hoja.getRange("A:B").getFormat().autofitColumns();

  // Texto que Power Automate puede poner en el cuerpo de un correo
  return filas.map(([v, t]) => `${v}: $${t.toLocaleString("es-CO")}`).join("\n");
}</code></pre>
<p>En Power Automate el flujo tiene tres pasos: <em>Periodicidad</em> (lunes, 7:00), <em>Ejecutar script</em> sobre el libro en OneDrive o SharePoint y <em>Enviar un correo</em> con el resultado. El gerente recibe el resumen antes de llegar a la oficina, sin que nadie abra Excel.</p>

<h3>Copilot y Python en Excel: la IA dentro de la hoja</h3>
<p>El panorama a octubre de 2026: el modo agente de Copilot, que edita el libro en varios pasos, está <a href="https://techcommunity.microsoft.com/blog/excelblog/agent-mode-in-excel-is-now-generally-available-on-desktop/4457408" target="_blank" rel="noopener">disponible de forma general</a> en Excel para la web, Windows y Mac; la función de celda <code>=COPILOT()</code> <a href="https://support.microsoft.com/en-us/excel/functions/copilot-function" target="_blank" rel="noopener">se retiró el 14 de septiembre de 2026</a> sin haber salido de la vista previa, y <a href="https://support.microsoft.com/office/python-in-excel-availability-781383e6-86b9-4156-84fb-93e786f7cab0" target="_blank" rel="noopener">Python en Excel</a> está disponible para planes empresariales en Windows, Mac y la web, y en vista previa para Personal y Familia. El detalle de licencias y agentes está en mi guía de <a href="/copilot-agentes-excel-lenguaje-natural-copilot-pages/">Copilot y agentes en Excel</a>. Aquí me interesa la diferencia entre un prompt de aficionado y uno profesional.</p>
<pre><code>PROMPT DÉBIL
Hazme un análisis de las ventas.

PROMPT PROFESIONAL
Usa la tabla Ventas (Fecha, Vendedor, Ciudad, Producto, Total).
Objetivo: preparar el comité comercial de octubre.
1) Crea en una hoja nueva el total por vendedor y mes con fórmulas
   (AGRUPARPOR o PIVOTARPOR), nunca con valores pegados.
2) Calcula la variación de septiembre frente a agosto por vendedor.
3) Señala los tres productos que más cayeron y en qué ciudad.
4) Agrega una celda Control que compare el total del resumen con
   SUMA(Ventas[Total]); debe dar 0.
Muéstrame el plan antes de modificar el libro.</code></pre>
<p>El primero produce un párrafo genérico; el segundo produce fórmulas auditables y una celda que te dice si algo se perdió en el camino. Y si quieres estadística de verdad, una celda <code>=PY</code> clasifica el inventario con el método ABC (Pareto) en cinco líneas; la lógica la probé con pandas:</p>
<pre><code># Celda =PY: clasificación ABC de productos por ventas
df = xl("Ventas[#Todo]", headers=True)
abc = df.groupby("Producto", as_index=False)["Total"].sum().sort_values("Total", ascending=False)
abc["% acumulado"] = abc["Total"].cumsum() / abc["Total"].sum()
abc["Clase"] = np.where(abc["% acumulado"] <= 0.8, "A", np.where(abc["% acumulado"] <= 0.95, "B", "C"))
abc</code></pre>
<p>Cómo verificar lo que produce la IA, en cuatro pasos que no dependen de ella: exige fórmulas y no valores; abre tres fórmulas al azar y léelas; agrega una celda de control que compare totales y debe dar cero; y prueba con un caso cuyo resultado conoces de memoria. Si no sabes leer la fórmula que Copilot escribió, no estás usando IA: estás apostando.</p>

<h2>Cómo cambia el trabajo: la IA amplifica al que entiende los datos</h2>
<p>Este es el centro de mi argumento: la IA no nivela a todos hacia arriba, <strong>multiplica lo que ya sabes</strong>. Al analista que entiende tablas, relaciones y periodos comparables, Copilot le ahorra horas y él detecta el error en segundos. A quien no sabe qué es un modelo de datos, la misma IA le entrega con total seguridad un informe que compara seis meses contra doce, como el −46 % de arriba. Los dos «usan IA»; solo uno trabaja mejor.</p>
<p>Por eso el Foro Económico Mundial no se contradice: crecen las habilidades de IA y datos, y el pensamiento analítico sigue siendo el más valorado. Para la mayoría, Excel es donde se aprende ese pensamiento: qué es una fila, una clave, un total que cuadra. Quien lo domina aprovecha la IA; quien no, depende de ella.</p>

<h2>Excel en las pymes: el BI de bajo costo que ya tienes instalado</h2>
<p>Para una pyme colombiana, la pregunta no es «Excel o Power BI», sino cuánto cuesta cada paso y qué retorno da. Estos son los precios de lista en dólares por usuario al mes con pago anual, verificados en las páginas de Microsoft:</p>
<table>
<thead><tr><th>Herramienta</th><th>Precio de lista</th><th>Qué aporta</th></tr></thead>
<tbody>
<tr><td>Microsoft 365 Business Standard</td><td>USD 14 (desde el 1 de julio de 2026; antes 12,50)</td><td>Excel de escritorio con Power Query, Power Pivot, tablas dinámicas y VBA, más correo y Teams</td></tr>
<tr><td>Microsoft 365 Business Basic</td><td>USD 7</td><td>Excel para la web y móvil (sin Excel de escritorio)</td></tr>
<tr><td>Power BI Desktop</td><td>Gratis</td><td>Modelos y tableros en tu equipo, sin compartir en línea</td></tr>
<tr><td>Power BI Pro</td><td>USD 14</td><td>Publicar y compartir tableros con el equipo</td></tr>
<tr><td>Microsoft 365 Copilot Business</td><td>USD 21 (promoción de USD 18 hasta el 31 de diciembre de 2026)</td><td>Copilot en Excel, Word, Outlook y Teams para empresas de menos de 300 usuarios</td></tr>
<tr><td>Microsoft 365 Copilot (empresarial)</td><td>USD 30</td><td>Copilot completo con agentes</td></tr>
</tbody>
</table>
<p>Fuentes: <a href="https://www.microsoft.com/en-us/licensing/news/2026-m365-packaging-pricing-updates" target="_blank" rel="noopener">cambios de precios de Microsoft 365 de 2026</a>, <a href="https://www.microsoft.com/en-us/power-platform/products/power-bi/pricing" target="_blank" rel="noopener">precios de Power BI</a>, <a href="https://www.microsoft.com/en-us/copilot/blog/2025/12/02/microsoft-365-copilot-business-the-future-of-work-for-small-businesses/" target="_blank" rel="noopener">anuncio de Copilot Business</a> y <a href="https://www.microsoft.com/en-us/copilot/pricing/enterprise" target="_blank" rel="noopener">precios de Microsoft 365 Copilot</a>. Como referencia externa, la <a href="https://www.tableau.com/pricing/cloud" target="_blank" rel="noopener">página de precios de Tableau</a> parte de USD 75 por usuario al mes para el perfil Creator, y un ERP implica además implementación, capacitación y meses de ajuste.</p>
<p>La cuenta para una pyme de cinco personas: con Business Standard paga USD 70 al mes y tiene toda la pila; si una persona publica tableros, suma USD 14 de Power BI Pro. No digo que una pyme no necesite un ERP; digo que muchas compran software antes de saber qué quieren medir y terminan exportando del ERP… a Excel. Yo lo haría al revés: ordena los datos, mide con tablas dinámicas, automatiza lo repetitivo y, cuando la hoja se quede corta, migra con los indicadores ya definidos.</p>

<h2>Casos de uso por cargo: fórmulas para mañana a primera hora</h2>
<h3>Contabilidad: conciliación bancaria con tolerancia de fechas</h3>
<p>El banco registra el pago el 5 y el libro el 6. BUSCARX con condiciones múltiples busca el mismo valor con hasta tres días de diferencia y devuelve el comprobante:</p>
<pre><code>Columna Comprobante en la tabla Banco:
=BUSCARX(1; (Libro[Valor] = [@Valor]) * (ABS(Libro[Fecha] - [@Fecha]) <= 3);
         Libro[Comprobante]; "Pendiente")

Total pendiente por conciliar:
=SUMAR.SI(Banco[Comprobante]; "Pendiente"; Banco[Valor])</code></pre>
<p>En mi prueba, un pago del 1 de septiembre cruzó con el comprobante del 30 de agosto, y otro del mismo valor del 12 de septiembre quedó pendiente porque el libro lo tenía el 20: justo lo que debe revisar un contador. Para facturar sin errores, la <a href="/producto/factura-con-envio-por-correo-al-cliente/">factura con envío por correo al cliente</a> trae la numeración y el envío resueltos, y el <a href="/herramientas/numero-a-letras/">convertidor de número a letras</a> tiene módulo gratuito para Excel con la función <code>=NUMEROALETRAS()</code>.</p>

<h3>Dueño de pyme: flujo de caja e inventario</h3>
<pre><code>Saldo de caja semana a semana, desde un saldo inicial en B1 (SCAN):
=SCAN(B1; Flujo[Ingresos] - Flujo[Egresos]; LAMBDA(saldo; mov; saldo + mov))

Alerta de reposición con la venta de los últimos 30 días:
=LET(diaria; SUMAR.SI.CONJUNTO(Ventas[Unidades]; Ventas[Producto]; [@Producto];
                                Ventas[Fecha]; ">=" & HOY() - 30) / 30;
     punto; diaria * [@[Días de entrega]] + [@[Stock de seguridad]];
     SI([@Existencias] <= punto; "Pedir ya"; "OK"))</code></pre>
<p>Con saldo inicial de 1.000.000, ingresos de 5.000.000 y egresos de 3.200.000, SCAN devuelve 2.800.000 la primera semana y sigue acumulando: si una semana va a quedar en negativo, lo ves antes. Para marcar los activos y la mercancía, el <a href="/producto/generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras/">generador de etiquetas con QR y códigos de barras</a> imprime las etiquetas desde la misma tabla.</p>

<h3>Talento humano: horas extra y asistencia</h3>
<pre><code>Horas extra de un turno, aunque cruce la medianoche:
=LET(h; RESIDUO([@Salida] - [@Entrada]; 1) * 24; MAX(0; h - 8))

Porcentaje de asistencia de una fila (A = asistió):
=CONTAR.SI(C2:X2; "A") / CONTARA(C2:X2)</code></pre>
<p>RESIDUO (MOD) resuelve el clásico turno de 10:00 p. m. a 6:00 a. m. que da horas negativas. Las reglas de recargos nocturnos y dominicales dependen de la ley vigente y de tu convenio, así que pon las tarifas en una tabla de parámetros y no dentro de la fórmula. Si llevas control de asistencia, el <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">listado de asistencia laboral o académica</a> ya trae los cálculos.</p>

<h3>Ventas: tablero de comisiones</h3>
<p>Combina lo anterior: <code>COMISION</code> como columna calculada, AGRUPARPOR para el total por vendedor, una tabla dinámica con segmentación por mes y la macro de PDF para que cada vendedor reciba su liquidación. Lo que tomaba una tarde queda en minutos.</p>

<h3>Docentes y directivos: notas y asistencia</h3>
<pre><code>Nota definitiva con pesos por periodo (C2:E2 notas, Pesos en H2:H4):
=REDONDEAR(SUMAPRODUCTO(C2:E2; TRANSPONER(Pesos)); 1)

Desempeño según la escala del SIEE (tabla Escala ordenada por Desde):
=BUSCARX([@Definitiva]; Escala[Desde]; Escala[Desempeño]; "Sin nota"; -1)</code></pre>
<p>Si eres docente, la IA te sirve sobre todo para preparar clases y evaluaciones: armé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> con prompts probados por área y el <a href="/herramientas/generador-de-examenes/">generador de exámenes con IA</a>, que crea versiones y solucionario. Lo que pasa después, consolidar notas, va en Excel.</p>

<h3>Logística: entregas a tiempo y completas (OTIF)</h3>
<pre><code>Porcentaje de pedidos entregados a tiempo y completos:
=PROMEDIO((Despachos[Entrega] <= Despachos[Prometida]) *
          (Despachos[Cant. entregada] >= Despachos[Cant. pedida]))</code></pre>
<p>Con cuatro pedidos de prueba (uno tarde y otro incompleto), la fórmula devolvió 0,5: el 50 % OTIF, el indicador que más le importa a un cliente mayorista. Y si tus despachos llevan códigos, el <a href="/producto/generador-de-codigos-qr-masivos/">generador de códigos QR masivos</a> los crea por lotes; también puedes descargar gratis el módulo <code>=QR()</code> desde el <a href="/herramientas/generador-qr/">generador de QR</a>.</p>

<h2>Cuánto tiempo ahorras: manual frente a automatizado</h2>
<p>Esta tabla es <strong>ilustrativa</strong>: son estimaciones a partir de procesos que he automatizado con clientes y colegas, no una medición estadística. Tu caso puede variar, pero el orden de magnitud se repite:</p>
<table>
<thead><tr><th>Tarea</th><th>Manual</th><th>Automatizado</th><th>Herramienta</th></tr></thead>
<tbody>
<tr><td>Consolidar 12 archivos de sedes cada mes</td><td>3 a 4 horas</td><td>2 minutos (Actualizar todo)</td><td>Power Query</td></tr>
<tr><td>Generar y enviar 40 PDF por vendedor o cliente</td><td>2 a 3 horas</td><td>5 minutos</td><td>VBA</td></tr>
<tr><td>Conciliar 600 movimientos bancarios</td><td>Un día</td><td>1 hora (solo revisar pendientes)</td><td>BUSCARX y Power Query</td></tr>
<tr><td>Informe mensual con comparativo anual</td><td>4 horas</td><td>15 minutos</td><td>Power Pivot y tablas dinámicas</td></tr>
<tr><td>Resumen semanal por correo al gerente</td><td>45 minutos</td><td>0 (programado)</td><td>Office Scripts y Power Automate</td></tr>
<tr><td>Consolidar notas de seis cursos</td><td>Un día</td><td>1 hora</td><td>Fórmulas dinámicas</td></tr>
</tbody>
</table>
<p>Para aprender a construirlas, en <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">Cómo automatizar tareas en Excel y reducir errores</a> explico la lógica, y en <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ" target="_blank" rel="noopener">mi lista de reproducción de Excel en YouTube</a> tienes tutoriales paso a paso, desde fórmulas hasta macros.</p>

<h2>Dónde Excel no es la herramienta correcta</h2>
<p>Defender Excel no es defenderlo para todo. Estos son sus límites reales, con casos documentados:</p>
<ul>
<li><strong>Volumen.</strong> Una hoja tiene <a href="https://support.microsoft.com/en-us/office/excel-specifications-and-limits-1672b34d-7043-467e-8e27-269d656771c3" target="_blank" rel="noopener">1.048.576 filas por 16.384 columnas</a>. El modelo de datos admite muchas más, pero si hablas de decenas de millones de registros que crecen cada día, necesitas una base de datos.</li>
<li><strong>Muchos usuarios escribiendo a la vez.</strong> La coautoría sirve para editar un libro, no para que treinta personas registren pedidos simultáneos con reglas de integridad: eso es trabajo de una base de datos.</li>
<li><strong>Control de versiones.</strong> «Informe_final_v3_ahora_sí.xlsx» no es control de versiones. Si un número afecta dinero público, salud o inversiones, necesitas revisión por pares y registro de cambios.</li>
<li><strong>Procesos críticos sin revisión.</strong> En octubre de 2020, Public Health England <a href="https://www.gov.uk/government/news/phe-statement-on-delayed-reporting-of-covid-19-cases" target="_blank" rel="noopener">dejó de reportar 15.841 casos positivos de covid-19</a> entre el 25 de septiembre y el 2 de octubre porque los archivos superaron su tamaño máximo; la <a href="https://www.bbc.com/news/technology-54423988" target="_blank" rel="noopener">BBC explicó</a> que se usaba el antiguo formato .xls, limitado a 65.536 filas.</li>
<li><strong>Modelos financieros copiados a mano.</strong> El <a href="https://elischolar.library.yale.edu/ypfs-documents/454" target="_blank" rel="noopener">informe interno de JPMorgan</a> sobre «la Ballena de Londres» (pérdidas de más de 6.000 millones de dólares en 2012) describe un modelo de riesgo en hojas de Excel llenadas copiando y pegando, con una fórmula que dividía por la suma en lugar del promedio.</li>
<li><strong>Investigación académica.</strong> En 2013, <a href="https://zenodo.org/records/4017423" target="_blank" rel="noopener">Herndon, Ash y Pollin</a> encontraron que el influyente estudio de Reinhart y Rogoff sobre deuda y crecimiento omitía cinco países por un rango mal seleccionado en Excel. Ese error explicaba solo una parte de la diferencia (el resto venía de exclusiones de datos y ponderaciones discutibles), pero bastó para poner en duda una tesis muy citada en los debates sobre austeridad.</li>
<li><strong>Conversiones automáticas.</strong> Un <a href="https://genomebiology.biomedcentral.com/articles/10.1186/s13059-016-1044-7" target="_blank" rel="noopener">estudio de 2016 en Genome Biology</a> halló que cerca de una quinta parte de los artículos con listas de genes en Excel tenía nombres convertidos en fechas (SEPT1 pasaba a «1-sep»). En 2020, el comité internacional de nomenclatura <a href="https://blog.genenames.org/newsletters/2020/08/28/Summer_newsletter/" target="_blank" rel="noopener">renombró esos genes</a> (SEPT1 es ahora SEPTIN1).</li>
</ul>
<p>Y una cifra para la humildad: en estudios que inspeccionaron a fondo 85 hojas de cálculo, Ray Panko reportó <a href="https://arxiv.org/abs/1602.02601" target="_blank" rel="noopener">errores en el 94 % de ellas</a>. La lección no es abandonar Excel, sino usarlo como profesional: tablas estructuradas, Power Query en vez de copiar y pegar, celdas de control y una segunda persona que revise. Casi todos esos desastres nacen de procesos manuales, justo lo que la pila moderna elimina.</p>

<h2>¿Estás obsoleto? Autoevaluación de nivel 1 a 5 y ruta de aprendizaje</h2>
{{img:niveles}}
<p>Ubícate con honestidad. Marca lo que ya haces sin buscar en internet:</p>
<ul>
<li><strong>Nivel 1, capturista:</strong> escribes datos y sumas con la calculadora al lado. Aprende ahora: tablas con Ctrl+T, SUMAR.SI.CONJUNTO, filtros y ordenar.</li>
<li><strong>Nivel 2, operativo:</strong> usas BUSCARV, filtros y una tabla dinámica básica. Aprende: BUSCARX, FILTRAR, UNICOS y validación de datos.</li>
<li><strong>Nivel 3, analista:</strong> usas matrices dinámicas, LET y tablas dinámicas con segmentaciones. Aprende: Power Query para combinar carpetas y anular dinamización.</li>
<li><strong>Nivel 4, modelador:</strong> trabajas con Power Query, modelo de datos, medidas DAX y tableros. Aprende: VBA u Office Scripts, LAMBDA y Power Automate.</li>
<li><strong>Nivel 5, automatizador aumentado:</strong> automatizas, usas Copilot y Python, y auditas lo que la IA produce. Aprende: gobierno de datos, Power BI y SQL básico.</li>
</ul>
<p>Sube un nivel por trimestre aplicándolo a un informe real de tu trabajo. Un nivel 3 con criterio vale más que un nivel 1 con licencia de Copilot.</p>

<p class="notice"><strong>Empieza hoy, sin empezar de cero.</strong> Descarga gratis el <a href="/descargas/excel-con-ia/excel-con-ia.zip">kit Excel con IA</a> (macros para perfilar datos y clasificar con tu propia clave gratuita de Gemini) y los módulos de <a href="/herramientas/numero-a-letras/">número a letras</a> y <a href="/herramientas/generador-qr/">códigos QR</a>. Cuando quieras automatizar un proceso completo, en la sección de <a href="/excel/">Excel y automatización</a> están las plantillas que uso con mis clientes: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">correos masivos con adjuntos</a>, <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">documentos separados en Word y PDF</a>, <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">factura con numeración automática</a> y, si necesitas que te acompañe en la implementación, la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Excel va a desaparecer por la inteligencia artificial?</h3>
<p>No hay señales de eso. Microsoft integra la IA dentro de Excel (Copilot, modo agente, Python) y en 2025 Excel apareció en más de 3,2 millones de avisos de empleo solo en Estados Unidos. Lo que pierde valor es el uso manual y repetitivo.</p>
<h3>¿Qué debo aprender primero para no quedarme atrás?</h3>
<p>Tablas (Ctrl+T), BUSCARX y FILTRAR, tablas dinámicas y luego Power Query. Con esas cuatro herramientas automatizas la mayor parte del trabajo repetitivo de una oficina. Después, DAX o macros según tu rol.</p>
<h3>¿Es mejor aprender Python o Power BI que Excel?</h3>
<p>No son excluyentes: Power Query y DAX son los mismos en Excel y en Power BI, y Python ya funciona dentro de Excel. Para la mayoría de los cargos administrativos, Excel moderno es el primer escalón y el de mejor retorno.</p>
<h3>¿Necesito pagar Copilot para usar IA con Excel?</h3>
<p>No necesariamente. Puedes pedirle fórmulas a ChatGPT, Gemini o Claude describiendo tu tabla sin pegar datos personales, o usar mi módulo gratuito ExcelConIA. Copilot trabaja dentro del libro, pero la verificación sigue siendo tuya.</p>
<h3>¿Las macros VBA siguen sirviendo en 2026?</h3>
<p>Sí, en Excel de escritorio para Windows son la forma más directa de automatizar archivos, PDF y correos. Para Excel en la web y flujos en la nube, la alternativa son los Office Scripts con Power Automate.</p>

<h2>Para pensar</h2>
<p>Durante décadas, saber Excel fue una ventaja; luego se volvió un requisito; ahora la IA promete que ya no hará falta saberlo. Pero cuando todos puedan pedirle a una máquina «hazme el informe», el valor ya no estará en hacerlo, sino en saber si está bien hecho. <strong>Si una generación aprende a pedir fórmulas sin aprender a leerlas, ¿estaremos formando profesionales más productivos o personas que firman números que no entienden? ¿Y quién debería responder por esa brecha: cada trabajador, las empresas que exigen rapidez o los colegios y universidades que todavía enseñan Excel como si fuera 2005?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:datos}}' => $img('excel-muerto-ia-datos', 720, 'Gráfico de barras con el software más pedido en ofertas de empleo de Estados Unidos en 2025 (Microsoft Office 3,42 millones, Excel 3,21 millones, Outlook 1,71, PowerPoint 1,62, Word 0,96, Python 0,81, SQL 0,76, Power BI 0,36 y Tableau 0,28) y barra apilada con cómo llevan las cuentas los micronegocios en Colombia en 2024: 68,2 % sin registros, 27,1 % informal y 4,7 % formal', 'Excel es la segunda tecnología más pedida en avisos de empleo, mientras que dos de cada tres micronegocios colombianos no llevan registros. Fuentes: O*NET/Lightcast, DANE, Eurostat y Confecámaras.'),
    '{{img:pila}}' => $img('excel-muerto-ia-pila', 687, 'Diagrama de la pila moderna de Excel: datos de origen (ERP, CSV del banco, carpetas, bases SQL, web) pasan por Power Query para limpiar, Power Pivot y DAX para modelar, tablas dinámicas para presentar y VBA u Office Scripts para automatizar, sobre una base de fórmulas dinámicas y con Copilot y Python como capa de IA', 'La pila moderna: cada capa reemplaza una tarea manual, y la IA asiste en todas.'),
    '{{img:niveles}}' => $img('excel-muerto-ia-niveles', 653, 'Escalera de cinco niveles de Excel: capturista, operativo, analista, modelador y automatizador aumentado, con lo que hace cada uno, qué aprender para subir y el tiempo ilustrativo de un informe mensual (de 2 días a 10 minutos)', 'Autoevaluación: ubica tu nivel y aprende lo de la siguiente columna. Tiempos ilustrativos.'),
]);

return [
    'slug' => 'excel-esta-muerto-era-de-la-ia',
    'title' => '¿Excel está muerto en la era de la IA? Lo que caducó no es la herramienta',
    'excerpt' => 'Excel no está muerto en la era de la IA: lo obsoleto es usarlo para copiar y pegar. Datos de empleo y pymes, la pila moderna (Power Query, DAX, tablas dinámicas, VBA, Office Scripts, Copilot y Python), costos, límites reales y ejemplos probados para contadores, pymes, talento humano, ventas, docentes y logística.',
    'seo_title' => '¿Excel está muerto en la era de la IA? Datos y ejemplos',
    'seo_description' => '¿Excel está muerto? Datos de empleo y pymes, Power Query, DAX, VBA, Copilot y Python con ejemplos probados, costos reales y autoevaluación de 5 niveles.',
    'focus_keyword' => 'Excel en la era de la IA',
    'cover' => '/assets/img/articulos/excel-muerto-ia/excel-muerto-ia-portada',
    'cover_alt' => 'Portada ¿Excel está muerto en la era de la IA?: una tarjeta tachada con BUSCARV y copiar y pegar frente a un libro moderno con AGRUPARPOR, indicadores de ventas y margen, barras por vendedor y chips de Power Query, DAX, LAMBDA, VBA, Copilot y Python',
    'published_at' => '2026-10-09 18:00:00',
    'content_html' => $html,
];
