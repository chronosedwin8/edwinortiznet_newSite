Attribute VB_Name = "ExcelConIA"
'==============================================================================
' ExcelConIA - perfila tus datos y usa inteligencia artificial (Google Gemini)
' desde Excel. Gratis. Autor: Edwin Ortiz Herazo - https://www.edwinortiz.net/
' Versión 1.0 (octubre de 2026). Excel 2016, 2019, 2021 y Microsoft 365.
'
' MACROS (Alt+F8)
'   PerfilarDatos     Haz clic dentro de una tabla (la primera fila son los
'                     encabezados) y ejecútala. Crea o reemplaza la hoja
'                     «Perfil de datos» con, por cada columna: tipo inferido
'                     (Número, Fecha, Texto, Mixto, Vacía), datos, vacíos,
'                     % de vacíos, valores únicos, mínimo, máximo, promedio,
'                     mediana, valor más frecuente y alertas de calidad
'                     (vacíos, tipos mezclados, posible ID, espacios sobrantes,
'                     variantes de escritura, valores atípicos por rango
'                     intercuartílico). También cuenta las filas duplicadas.
'                     Al final te pregunta qué quieres lograr y genera el prompt.
'   GenerarPromptIA   Escribe en «Perfil de datos» un prompt listo para pegar en
'                     ChatGPT, Gemini, Copilot o Claude y lo copia al
'                     portapapeles. Describe la ESTRUCTURA y las ESTADÍSTICAS
'                     de la tabla, nunca sus filas, y pide pasos de limpieza,
'                     5 preguntas de análisis, las fórmulas exactas de Excel y
'                     el código equivalente en Python (pandas).
'   ConfigurarIA      Guarda (o borra) tu clave de Google Gemini en este libro.
'   LimpiarCacheIA    Olvida las respuestas de IA guardadas en memoria.
'
' FUNCIONES (se escriben en una celda, como =SUMA; Excel en español usa «;»)
'   =IA("Resume en 10 palabras"; A2)                  instrucción libre
'   =IA("¿Qué ciudad vende más?"; A1:C20)              con un rango de contexto
'   =IA_CLASIFICAR(B2; $H$2:$H$6)                     una de las categorías
'   =IA_CLASIFICAR(B2; "Positivo, Negativo, Neutro")  categorías en un texto
'   =IA_EXTRAER(C2; "correo")                         extrae un dato del texto
'   (campos útiles: correo, teléfono, ciudad, monto, fecha, nombre, documento)
'   Si algo falla devuelven un texto que empieza por «#IA:» con la causa.
'
' CÓMO INSTALARLO
'   1. En Excel pulsa Alt+F11 (editor de Visual Basic).
'   2. Menú Archivo > Importar archivo... y elige ExcelConIA.bas.
'   3. Guarda tu libro como «Libro de Excel habilitado para macros (*.xlsm)».
'   Para usar las funciones IA ejecuta antes ConfigurarIA (clave gratuita en
'   https://aistudio.google.com/apikey). PerfilarDatos y GenerarPromptIA no
'   necesitan clave ni internet.
'
' PRIVACIDAD Y COSTOS
'   - PerfilarDatos y GenerarPromptIA trabajan solo en tu computador. El prompt
'     no incluye filas, pero sí nombres de columnas, mínimos, máximos y el valor
'     más frecuente de cada columna: revísalo antes de pegarlo. Para omitir el
'     valor más frecuente pon INCLUIR_VALOR_FRECUENTE = False (más abajo).
'   - IA, IA_CLASIFICAR e IA_EXTRAER envían a Google el texto de la instrucción
'     y de las celdas que les pases. Usa datos anonimizados: sin nombres,
'     documentos, teléfonos ni datos de salud de personas reales.
'   - Con el nivel gratuito de la API, Google puede usar lo que envías para
'     mejorar sus productos y hay límites de consultas por minuto y por día
'     (si los superas verás «#IA: límite de la API...»). Con facturación
'     activa, cada consulta tiene un costo: revisa los precios de Google.
'   - Cada celda con una función IA es una consulta. Las respuestas se guardan
'     en memoria mientras Excel está abierto, así que recalcular no repite las
'     consultas ya hechas. Al cerrar el libro las celdas conservan su valor.
'   - La clave se guarda oculta y SIN CIFRAR dentro del libro: no compartas un
'     libro que tenga tu clave. Alternativa: la variable de entorno de Windows
'     GEMINI_API_KEY (ConfigurarIA > BORRAR quita la del libro).
'
' MAC: PerfilarDatos funciona. Las funciones IA necesitan Windows (en Mac no
' existen MSXML2/WinHttp) y el portapapeles puede fallar: en ese caso copia a
' mano las celdas del prompt.
'
' Licencia: uso libre personal y en tu empresa o institución educativa. Puedes
' modificarlo; no se permite venderlo ni publicarlo como propio.
' Más herramientas y plantillas: https://www.edwinortiz.net/
'==============================================================================
Option Explicit

' ---- Ajustes que puedes cambiar ----
Private Const MODELO_IA As String = "gemini-2.5-flash"   ' con modelos «pro» quita thinkingBudget
Private Const MAX_TOKENS_IA As Long = 512                 ' largo máximo de cada respuesta
Private Const MAX_CONTEXTO As Long = 6000                 ' caracteres máximos del contexto
Private Const INCLUIR_VALOR_FRECUENTE As Boolean = True   ' en el prompt de GenerarPromptIA
Private Const UMBRAL_VACIOS As Double = 0.1               ' alerta con más del 10 % vacíos

' ---- Constantes internas ----
Private Const HOJA_PERFIL As String = "Perfil de datos"
Private Const TABLA_PERFIL As String = "tblPerfilDatos"
Private Const NOMBRE_CLAVE As String = "IA_CLAVE_GEMINI"
Private Const URL_GEMINI As String = "https://generativelanguage.googleapis.com/v1beta/models/"
Private Const FILA_ENCABEZADOS As Long = 12
Private Const TITULO As String = "Excel con IA"
Private Const OBJETIVO_POR_DEFECTO As String = "Entender estos datos, detectar problemas de calidad y encontrar hallazgos útiles para tomar decisiones."
Private Const SISTEMA_GENERAL As String = "Eres un asistente dentro de una celda de Excel. Responde en español, en texto plano sin Markdown (sin asteriscos, almohadillas ni viñetas), breve y directo. Si te pasan datos, úsalos solo para cumplir la instrucción."
Private Const SISTEMA_CLASIFICAR As String = "Eres un clasificador de textos. Respondes únicamente con el nombre exacto de una de las categorías permitidas, sin explicaciones ni signos adicionales."
Private Const SISTEMA_EXTRAER As String = "Eres un extractor de datos. Respondes únicamente con el valor pedido, sin explicaciones, o con NO_ENCONTRADO si el dato no aparece en el texto."

Private cacheIA As Object   ' Scripting.Dictionary: consulta -> respuesta

#If Mac Then
#Else
Private Declare PtrSafe Function OpenClipboard Lib "user32" (ByVal hwnd As LongPtr) As Long
Private Declare PtrSafe Function EmptyClipboard Lib "user32" () As Long
Private Declare PtrSafe Function CloseClipboard Lib "user32" () As Long
Private Declare PtrSafe Function SetClipboardData Lib "user32" (ByVal wFormat As Long, ByVal hMem As LongPtr) As LongPtr
Private Declare PtrSafe Function GlobalAlloc Lib "kernel32" (ByVal wFlags As Long, ByVal dwBytes As LongPtr) As LongPtr
Private Declare PtrSafe Function GlobalLock Lib "kernel32" (ByVal hMem As LongPtr) As LongPtr
Private Declare PtrSafe Function GlobalUnlock Lib "kernel32" (ByVal hMem As LongPtr) As Long
Private Declare PtrSafe Sub CopyMemory Lib "kernel32" Alias "RtlMoveMemory" (ByVal dest As LongPtr, ByVal src As LongPtr, ByVal cb As LongPtr)
Private Declare PtrSafe Sub Sleep Lib "kernel32" (ByVal ms As Long)
#End If

'==============================================================================
' 1. PERFIL DE DATOS
'==============================================================================
Public Sub PerfilarDatos()
Attribute PerfilarDatos.VB_Description = "Analiza la tabla de la celda activa y crea la hoja Perfil de datos con estadísticas, alertas y un prompt para tu IA."
    PerfilarInterno "", True
End Sub

' Igual que PerfilarDatos, pero sin preguntar el objetivo (para llamarla desde
' otra macro: PerfilarDatosConObjetivo "Saber qué ciudad crece más").
Public Sub PerfilarDatosConObjetivo(ByVal objetivo As String)
    PerfilarInterno objetivo, False
End Sub

Private Sub PerfilarInterno(ByVal objetivo As String, ByVal preguntar As Boolean)
    Dim ws As Worksheet, wsP As Worksheet, rng As Range
    Dim datos As Variant, nF As Long, nC As Long, i As Long, j As Long
    Dim t0 As Double, calcAnt As Long, eventosAnt As Boolean
    Dim salida() As Variant, formatos() As Long, fila As Variant, formato As Long
    Dim vaciasTotal As Long, vacias As Long, duplicadas As Long, nombre As String, nombres() As String
    Dim lo As ListObject, origen As String, celdaF As Range

    If TypeName(ActiveSheet) <> "Worksheet" Then
        Avisar "Abre la hoja que tiene tus datos y haz clic dentro de la tabla.", vbExclamation
        Exit Sub
    End If
    Set ws = ActiveSheet
    If ws.Name = HOJA_PERFIL Then
        Avisar "Esta es la hoja de resultados. Ve a la hoja con tus datos, haz clic dentro de la tabla y vuelve a ejecutar PerfilarDatos.", vbExclamation
        Exit Sub
    End If
    Set rng = RangoDeDatos(ActiveCell, origen)
    If rng Is Nothing Then
        Avisar "No encontré una tabla alrededor de la celda activa." & vbLf & _
               "Haz clic dentro de tus datos: la primera fila debe tener los encabezados y debe haber al menos una fila de datos.", vbExclamation
        Exit Sub
    End If

    t0 = Timer
    calcAnt = Application.Calculation
    eventosAnt = Application.EnableEvents
    Application.ScreenUpdating = False
    Application.EnableEvents = False
    Application.Calculation = xlCalculationManual
    On Error GoTo Fallo

    datos = rng.Value
    nF = UBound(datos, 1) - 1
    nC = UBound(datos, 2)

    ' Nombres de columna (detecta encabezados vacíos o repetidos)
    ReDim nombres(1 To nC)
    For j = 1 To nC
        nombres(j) = Trim$(TextoCelda(datos(1, j)))
    Next j

    ReDim salida(1 To nC, 1 To 12)
    ReDim formatos(1 To nC)
    For j = 1 To nC
        nombre = nombres(j)
        If Len(nombre) = 0 Then nombre = "Columna " & j
        AnalizarColumna datos, j, nF, nombre, fila, vacias, formato
        If Len(nombres(j)) = 0 Then
            fila(11) = UnirAlerta("sin encabezado", CStr(fila(11)))
        ElseIf ContarIguales(nombres, nombres(j)) > 1 Then
            fila(11) = UnirAlerta("encabezado repetido", CStr(fila(11)))
        End If
        For i = 0 To 11
            salida(j, i + 1) = fila(i)
        Next i
        formatos(j) = formato
        vaciasTotal = vaciasTotal + vacias
    Next j
    duplicadas = ContarFilasDuplicadas(datos, nF, nC)

    ' ---- Hoja de resultados (se reemplaza) ----
    Application.DisplayAlerts = False
    On Error Resume Next
    ws.Parent.Worksheets(HOJA_PERFIL).Delete
    On Error GoTo Fallo
    Application.DisplayAlerts = True
    Set wsP = ws.Parent.Worksheets.Add(After:=ws)
    wsP.Name = HOJA_PERFIL
    wsP.Cells.Font.Size = 10

    With wsP.Range("A1")
        .Value = "Perfil de datos"
        .Font.Size = 18
        .Font.Bold = True
        .Font.Color = RGB(35, 80, 240)
    End With
    wsP.Range("A2").Value = "Estructura y estadísticas de la tabla (no se copian filas). Generado con ExcelConIA · edwinortiz.net"
    wsP.Range("A2").Font.Color = RGB(96, 96, 96)

    wsP.Range("A4:B10").NumberFormat = "@"
    wsP.Range("A4:A10").Value = Application.Transpose(Array("Hoja de origen", "Rango", "Filas de datos", _
        "Columnas", "Filas duplicadas", "Celdas vacías", "Generado"))
    wsP.Range("B4").Value = ws.Name
    wsP.Range("B5").Value = origen
    wsP.Range("B6:B8").NumberFormat = "#,##0"
    wsP.Range("B6").Value = nF
    wsP.Range("B7").Value = nC
    wsP.Range("B8").Value = duplicadas
    wsP.Range("B9").Value = Format$(vaciasTotal, "#,##0") & " (" & Format$(vaciasTotal / (CDbl(nF) * nC), "0.0 %") & ")"
    wsP.Range("A4:A10").Font.Bold = True
    wsP.Range("B4:B10").HorizontalAlignment = xlLeft
    If duplicadas > 0 Then
        wsP.Range("B8").Font.Color = RGB(176, 0, 32)
        wsP.Range("C8").Value = "copias exactas de otra fila"
        wsP.Range("C8").Font.Color = RGB(176, 0, 32)
    End If

    ' Tabla de columnas
    Dim encab As Variant
    encab = Array("Columna", "Tipo inferido", "Con dato", "Vacíos", "% vacíos", "Únicos", "Mínimo", _
                  "Máximo", "Promedio", "Mediana", "Más frecuente", "Alertas")
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS, 1), wsP.Cells(FILA_ENCABEZADOS, 12)).Value = encab
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 1), wsP.Cells(FILA_ENCABEZADOS + nC, 2)).NumberFormat = "@"
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 11), wsP.Cells(FILA_ENCABEZADOS + nC, 12)).NumberFormat = "@"
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 1), wsP.Cells(FILA_ENCABEZADOS + nC, 12)).Value = salida
    Set lo = wsP.ListObjects.Add(xlSrcRange, wsP.Range(wsP.Cells(FILA_ENCABEZADOS, 1), wsP.Cells(FILA_ENCABEZADOS + nC, 12)), , xlYes)
    lo.Name = NombreTablaLibre(ws.Parent)
    lo.TableStyle = "TableStyleMedium2"

    ' Formatos por fila
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 3), wsP.Cells(FILA_ENCABEZADOS + nC, 4)).NumberFormat = "#,##0"
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 5), wsP.Cells(FILA_ENCABEZADOS + nC, 5)).NumberFormat = "0.0 %"
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 6), wsP.Cells(FILA_ENCABEZADOS + nC, 6)).NumberFormat = "#,##0"
    For j = 1 To nC
        i = FILA_ENCABEZADOS + j
        Select Case formatos(j)
            Case 1: wsP.Range(wsP.Cells(i, 7), wsP.Cells(i, 8)).NumberFormat = "#,##0"
            Case 2: wsP.Range(wsP.Cells(i, 7), wsP.Cells(i, 8)).NumberFormat = "#,##0.00"
            Case 3: wsP.Range(wsP.Cells(i, 7), wsP.Cells(i, 8)).NumberFormat = "dd/mm/yyyy"
        End Select
        If formatos(j) = 1 Or formatos(j) = 2 Then wsP.Range(wsP.Cells(i, 9), wsP.Cells(i, 10)).NumberFormat = "#,##0.00"
        ' Colores: tipo dudoso en naranja, alertas en rojo
        Select Case CStr(salida(j, 2))
            Case "Mixto": ColorCelda wsP.Cells(i, 2), RGB(255, 235, 205), RGB(156, 87, 0)
            Case "Vacía": ColorCelda wsP.Cells(i, 2), RGB(230, 230, 230), RGB(96, 96, 96)
        End Select
        If Len(CStr(salida(j, 12))) > 0 Then ColorCelda wsP.Cells(i, 12), RGB(255, 228, 228), RGB(156, 0, 6)
        If salida(j, 5) > UMBRAL_VACIOS Then wsP.Cells(i, 5).Font.Color = RGB(176, 0, 32)
    Next j
    Set celdaF = wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 5), wsP.Cells(FILA_ENCABEZADOS + nC, 5))
    With celdaF.FormatConditions.AddDatabar
        .BarColor.Color = RGB(255, 140, 140)
        .MinPoint.Modify xlConditionValueNumber, 0
        .MaxPoint.Modify xlConditionValueNumber, 1
    End With

    wsP.Columns("A").ColumnWidth = 26
    wsP.Columns("B").ColumnWidth = 14
    wsP.Columns("C:F").ColumnWidth = 10
    wsP.Columns("G:J").ColumnWidth = 13
    wsP.Columns("K").ColumnWidth = 28
    wsP.Columns("L").ColumnWidth = 70
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS + 1, 11), wsP.Cells(FILA_ENCABEZADOS + nC, 12)).WrapText = True
    wsP.Range(wsP.Cells(FILA_ENCABEZADOS, 1), wsP.Cells(FILA_ENCABEZADOS + nC, 12)).VerticalAlignment = xlTop
    wsP.Range("B10").Value = Format$(Now, "dd/mm/yyyy hh:nn") & " · en " & Format$(Timer - t0, "0.00") & " s"

    On Error Resume Next
    ActiveWindow.DisplayGridlines = False
    On Error GoTo Fallo

    Application.Calculation = calcAnt
    Application.EnableEvents = eventosAnt
    Application.ScreenUpdating = True
    GenerarPromptInterno objetivo, preguntar
    Exit Sub

Fallo:
    Application.DisplayAlerts = True
    Application.Calculation = calcAnt
    Application.EnableEvents = eventosAnt
    Application.ScreenUpdating = True
    Avisar "No se pudo crear el perfil: " & Err.Description, vbCritical
End Sub

' Tabla de Excel (ListObject) de la celda o región actual (CurrentRegion)
Private Function RangoDeDatos(ByVal celda As Range, ByRef origen As String) As Range
    Dim r As Range
    If Not celda.ListObject Is Nothing Then
        Set r = celda.ListObject.Range
        If celda.ListObject.ShowTotals Then Set r = r.Resize(r.Rows.Count - 1)
        origen = "tabla «" & celda.ListObject.Name & "» (" & r.Address(False, False) & ")"
    Else
        Set r = celda.CurrentRegion
        origen = r.Address(False, False)
    End If
    If r.Rows.Count < 2 Then Exit Function
    If Application.WorksheetFunction.CountA(r) = 0 Then Exit Function
    Set RangoDeDatos = r
End Function

' Analiza una columna. fila(0..11) = valores de la tabla; formato: 0 ninguno,
' 1 enteros, 2 decimales, 3 fechas (para mínimo y máximo)
Private Sub AnalizarColumna(datos As Variant, ByVal j As Long, ByVal nF As Long, ByVal nombre As String, _
                            ByRef fila As Variant, ByRef vacias As Long, ByRef formato As Long)
    Dim i As Long, v As Variant, s As String, k As Long
    Dim nNum As Long, nFec As Long, nTxt As Long, nErr As Long, nEsp As Long, nNumTxt As Long, nn As Long, nT As Long
    Dim claves() As String, textos() As String, nums() As Double, fechas() As Double
    Dim enteros As Boolean, tipo As String, categorias As Long, alertas As String
    Dim unicos As Long, racha As Long, modaN As Long, moda As String, distintosTxt As Long, distintosNorm As Long
    Dim minimo As Variant, maximo As Variant, promedio As Variant, mediana As Variant
    Dim suma As Double, q1 As Double, q3 As Double, riq As Double, atipicos As Long

    ReDim claves(1 To nF): ReDim textos(1 To nF): ReDim nums(1 To nF): ReDim fechas(1 To nF)
    enteros = True
    vacias = 0
    For i = 2 To nF + 1
        v = datos(i, j)
        Select Case VarType(v)
            Case vbEmpty, vbNull
                vacias = vacias + 1
            Case vbString
                s = v
                If Len(Trim$(s)) = 0 Then
                    vacias = vacias + 1
                Else
                    nTxt = nTxt + 1: nn = nn + 1: claves(nn) = "s" & s
                    nT = nT + 1: textos(nT) = LCase$(Trim$(s))
                    If s <> Trim$(s) Then nEsp = nEsp + 1
                    If PareceNumero(s) Then nNumTxt = nNumTxt + 1
                End If
            Case vbDate
                nFec = nFec + 1: fechas(nFec) = CDbl(v)
                nn = nn + 1: claves(nn) = "d" & CStr(CDbl(v))
            Case vbBoolean
                nTxt = nTxt + 1: nn = nn + 1: claves(nn) = "b" & CStr(v)
                nT = nT + 1: textos(nT) = LCase$(CStr(v))
            Case vbError
                nErr = nErr + 1: nn = nn + 1: claves(nn) = "e#error"
            Case Else
                nNum = nNum + 1: nums(nNum) = CDbl(v)
                nn = nn + 1: claves(nn) = "n" & CStr(nums(nNum))
                If nums(nNum) <> Int(nums(nNum)) Then enteros = False
        End Select
    Next i

    ' Tipo inferido
    categorias = -(nNum > 0) - (nFec > 0) - (nTxt > 0)
    If nn = 0 Then
        tipo = "Vacía"
    ElseIf categorias <> 1 Then
        tipo = "Mixto"
    ElseIf nNum > 0 Then
        tipo = "Número"
    ElseIf nFec > 0 Then
        tipo = "Fecha"
    Else
        tipo = "Texto"
    End If

    ' Únicos, valor más frecuente y variantes de escritura (ordenando, sin Dictionary)
    If nn > 0 Then
        ReDim Preserve claves(1 To nn)
        OrdenarTextos claves, 1, nn
        unicos = 1: racha = 1: modaN = 1: moda = claves(1)
        If EsClaveTexto(claves(1)) Then distintosTxt = 1
        For i = 2 To nn
            If claves(i) = claves(i - 1) Then
                racha = racha + 1
            Else
                unicos = unicos + 1: racha = 1
                If EsClaveTexto(claves(i)) Then distintosTxt = distintosTxt + 1
            End If
            If racha > modaN Then modaN = racha: moda = claves(i)
        Next i
    End If
    If nT > 0 Then
        ReDim Preserve textos(1 To nT)
        OrdenarTextos textos, 1, nT
        distintosNorm = 1
        For i = 2 To nT
            If textos(i) <> textos(i - 1) Then distintosNorm = distintosNorm + 1
        Next i
    End If

    ' Estadísticas según el tipo dominante
    formato = 0
    If nNum > 0 And nNum >= nFec And nNum >= nTxt Then
        ReDim Preserve nums(1 To nNum)
        OrdenarNumeros nums, 1, nNum
        For i = 1 To nNum
            suma = suma + nums(i)
        Next i
        minimo = nums(1): maximo = nums(nNum)
        promedio = suma / nNum
        mediana = Percentil(nums, nNum, 0.5)
        formato = IIf(enteros, 1, 2)
        If nNum >= 10 Then
            q1 = Percentil(nums, nNum, 0.25)
            q3 = Percentil(nums, nNum, 0.75)
            riq = q3 - q1
            If riq > 0 Then
                For i = 1 To nNum
                    If nums(i) < q1 - 1.5 * riq Or nums(i) > q3 + 1.5 * riq Then atipicos = atipicos + 1
                Next i
            End If
        End If
    ElseIf nFec > 0 And nFec >= nTxt Then
        ReDim Preserve fechas(1 To nFec)
        OrdenarNumeros fechas, 1, nFec
        minimo = CDate(fechas(1)): maximo = CDate(fechas(nFec))
        formato = 3
    End If

    ' Alertas
    If nn = 0 Then alertas = UnirAlerta(alertas, "columna vacía")
    If nF > 0 And nn > 0 Then
        If vacias / nF > UMBRAL_VACIOS Then alertas = UnirAlerta(alertas, ">" & Format$(UMBRAL_VACIOS, "0 %") & " vacíos")
    End If
    If categorias > 1 Then
        s = ""
        If nNum > 0 Then s = UnirLista(s, Format$(nNum, "#,##0") & IIf(nNum = 1, " número", " números"))
        If nFec > 0 Then s = UnirLista(s, Format$(nFec, "#,##0") & IIf(nFec = 1, " fecha", " fechas"))
        If nTxt > 0 Then s = UnirLista(s, Format$(nTxt, "#,##0") & IIf(nTxt = 1, " texto", " textos"))
        alertas = UnirAlerta(alertas, "tipos mezclados (" & s & ")")
    End If
    If nNumTxt > 0 And nNum > 0 Then alertas = UnirAlerta(alertas, "números guardados como texto: " & nNumTxt)
    If nn >= 10 And unicos = nn And (tipo = "Texto" Or (tipo = "Número" And enteros)) Then alertas = UnirAlerta(alertas, "posible ID (todos distintos)")
    If nEsp > 0 Then alertas = UnirAlerta(alertas, "espacios sobrantes: " & nEsp)
    If distintosNorm > 0 And distintosTxt > distintosNorm Then alertas = UnirAlerta(alertas, "variantes de mayúsculas o espacios: " & (distintosTxt - distintosNorm))
    If atipicos > 0 Then alertas = UnirAlerta(alertas, "valores atípicos (1,5×IQR): " & atipicos & ", fuera de " & NumTexto(q1 - 1.5 * riq) & " a " & NumTexto(q3 + 1.5 * riq))
    If nn > 1 And unicos = 1 Then alertas = UnirAlerta(alertas, "un solo valor")
    If nErr > 0 Then alertas = UnirAlerta(alertas, "celdas con error: " & nErr)

    fila = Array(nombre, tipo, nn, vacias, IIf(nF > 0, vacias / nF, 0), unicos, minimo, maximo, promedio, mediana, _
                 IIf(nn = 0, "", IIf(modaN > 1, MostrarClave(moda) & " (" & modaN & ")", "(sin repetidos)")), alertas)
End Sub

Private Function ContarFilasDuplicadas(datos As Variant, ByVal nF As Long, ByVal nC As Long) As Long
    Dim claves() As String, i As Long, j As Long, s As String
    If nF < 2 Then Exit Function
    ReDim claves(1 To nF)
    For i = 2 To nF + 1
        s = ""
        For j = 1 To nC
            s = s & ClaveValor(datos(i, j)) & ChrW(30)
        Next j
        claves(i - 1) = s
    Next i
    OrdenarTextos claves, 1, nF
    For i = 2 To nF
        If claves(i) = claves(i - 1) Then ContarFilasDuplicadas = ContarFilasDuplicadas + 1
    Next i
End Function

Private Function ClaveValor(ByVal v As Variant) As String
    Select Case VarType(v)
        Case vbEmpty, vbNull: ClaveValor = ""
        Case vbString: ClaveValor = "s" & v
        Case vbDate: ClaveValor = "d" & CStr(CDbl(v))
        Case vbBoolean: ClaveValor = "b" & CStr(v)
        Case vbError: ClaveValor = "e#error"
        Case Else: ClaveValor = "n" & CStr(CDbl(v))
    End Select
End Function

Private Function EsClaveTexto(ByVal clave As String) As Boolean
    Dim c As String
    c = Left$(clave, 1)
    EsClaveTexto = (c = "s" Or c = "b")
End Function

Private Function MostrarClave(ByVal clave As String) As String
    Dim resto As String
    resto = Mid$(clave, 2)
    Select Case Left$(clave, 1)
        Case "n": MostrarClave = NumTexto(CDbl(resto))
        Case "d": MostrarClave = Format$(CDate(CDbl(resto)), "dd/mm/yyyy")
        Case "e": MostrarClave = "#error"
        Case Else: MostrarClave = resto
    End Select
End Function

' Percentil inclusivo con interpolación lineal (igual que PERCENTIL.INC y pandas)
Private Function Percentil(a() As Double, ByVal n As Long, ByVal p As Double) As Double
    Dim pos As Double, base As Long
    pos = (n - 1) * p
    base = Int(pos)
    If base + 1 >= n Then
        Percentil = a(n)
    Else
        Percentil = a(base + 1) + (pos - base) * (a(base + 2) - a(base + 1))
    End If
End Function

Private Function PareceNumero(ByVal s As String) As Boolean
    Dim i As Long, c As String, digitos As Long
    s = Trim$(s)
    If Len(s) = 0 Or Len(s) > 30 Then Exit Function
    For i = 1 To Len(s)
        c = Mid$(s, i, 1)
        If c Like "#" Then
            digitos = digitos + 1
        ElseIf InStr(".,-+$ %", c) = 0 Then
            Exit Function
        End If
    Next i
    PareceNumero = digitos > 0
End Function

Private Sub OrdenarTextos(a() As String, ByVal izq As Long, ByVal der As Long)
    Dim i As Long, j As Long, pivote As String, tmp As String
    Do While izq < der
        i = izq: j = der
        pivote = a((izq + der) \ 2)
        Do While i <= j
            Do While a(i) < pivote: i = i + 1: Loop
            Do While pivote < a(j): j = j - 1: Loop
            If i <= j Then
                tmp = a(i): a(i) = a(j): a(j) = tmp
                i = i + 1: j = j - 1
            End If
        Loop
        ' Recursión en la parte pequeña: profundidad máxima log2(n)
        If j - izq < der - i Then
            If izq < j Then OrdenarTextos a, izq, j
            izq = i
        Else
            If i < der Then OrdenarTextos a, i, der
            der = j
        End If
    Loop
End Sub

Private Sub OrdenarNumeros(a() As Double, ByVal izq As Long, ByVal der As Long)
    Dim i As Long, j As Long, pivote As Double, tmp As Double
    Do While izq < der
        i = izq: j = der
        pivote = a((izq + der) \ 2)
        Do While i <= j
            Do While a(i) < pivote: i = i + 1: Loop
            Do While pivote < a(j): j = j - 1: Loop
            If i <= j Then
                tmp = a(i): a(i) = a(j): a(j) = tmp
                i = i + 1: j = j - 1
            End If
        Loop
        If j - izq < der - i Then
            If izq < j Then OrdenarNumeros a, izq, j
            izq = i
        Else
            If i < der Then OrdenarNumeros a, i, der
            der = j
        End If
    Loop
End Sub

Private Function ContarIguales(lista() As String, ByVal valor As String) As Long
    Dim i As Long
    If Len(valor) = 0 Then Exit Function
    For i = LBound(lista) To UBound(lista)
        If StrComp(lista(i), valor, vbTextCompare) = 0 Then ContarIguales = ContarIguales + 1
    Next i
End Function

Private Function NombreTablaLibre(ByVal wb As Workbook) As String
    Dim n As Long, nombre As String, h As Worksheet, lo As ListObject, existe As Boolean
    Do
        nombre = TABLA_PERFIL & IIf(n = 0, "", CStr(n))
        existe = False
        For Each h In wb.Worksheets
            For Each lo In h.ListObjects
                If StrComp(lo.Name, nombre, vbTextCompare) = 0 Then existe = True
            Next lo
        Next h
        n = n + 1
    Loop While existe
    NombreTablaLibre = nombre
End Function

Private Sub ColorCelda(ByVal c As Range, ByVal fondo As Long, ByVal letra As Long)
    c.Interior.Color = fondo
    c.Font.Color = letra
End Sub

Private Function UnirAlerta(ByVal a As String, ByVal b As String) As String
    If Len(a) = 0 Then
        UnirAlerta = b
    ElseIf Len(b) = 0 Then
        UnirAlerta = a
    Else
        UnirAlerta = a & "; " & b
    End If
End Function

Private Function UnirLista(ByVal a As String, ByVal b As String) As String
    UnirLista = IIf(Len(a) = 0, b, a & ", " & b)
End Function

' Número con separadores de la configuración regional: 24.900 o 3,75
Private Function NumTexto(ByVal x As Double) As String
    If x = Int(x) Then
        NumTexto = Format$(x, "#,##0")
    Else
        NumTexto = Format$(x, "#,##0.00")
    End If
End Function

Private Function TextoCelda(ByVal v As Variant) As String
    Select Case VarType(v)
        Case vbEmpty, vbNull, vbError: TextoCelda = ""
        Case vbDate: TextoCelda = Format$(v, "yyyy-mm-dd")
        Case Else: TextoCelda = CStr(v)
    End Select
End Function

'==============================================================================
' 2. PROMPT PARA TU ASISTENTE DE IA
'==============================================================================
Public Sub GenerarPromptIA()
Attribute GenerarPromptIA.VB_Description = "Escribe en la hoja Perfil de datos un prompt (sin tus filas) para ChatGPT, Gemini, Copilot o Claude y lo copia al portapapeles."
    GenerarPromptInterno "", True
End Sub

' Igual que GenerarPromptIA, pero con el objetivo ya escrito (sin preguntar).
Public Sub GenerarPromptIAConObjetivo(ByVal objetivo As String)
    GenerarPromptInterno objetivo, False
End Sub

Private Sub GenerarPromptInterno(ByVal objetivo As String, ByVal preguntar As Boolean)
    Dim wsP As Worksheet, lo As ListObject, d As Variant, L() As String, n As Long, j As Long
    Dim nC As Long, s As String, sep As String, dec As String, disponibles As String, faltan As String
    Dim filaIni As Long, ultima As Long, texto As String, copiado As Boolean, rngPrompt As Range, celdas() As Variant

    On Error Resume Next
    Set wsP = ActiveWorkbook.Worksheets(HOJA_PERFIL)
    On Error GoTo 0
    If wsP Is Nothing Then
        ' Sin perfil todavía: si la hoja activa tiene datos, se perfila primero
        If TypeName(ActiveSheet) = "Worksheet" Then
            If Application.WorksheetFunction.CountA(ActiveCell.CurrentRegion) > 1 Then
                PerfilarInterno objetivo, preguntar
                Exit Sub
            End If
        End If
        Avisar "Primero haz clic dentro de tus datos y ejecuta la macro PerfilarDatos.", vbExclamation
        Exit Sub
    End If
    If wsP.ListObjects.Count = 0 Then
        Avisar "La hoja «" & HOJA_PERFIL & "» no tiene la tabla del perfil. Vuelve a ejecutar PerfilarDatos.", vbExclamation
        Exit Sub
    End If
    Set lo = wsP.ListObjects(1)
    If lo.DataBodyRange Is Nothing Then Exit Sub

    If preguntar And Application.Visible Then
        objetivo = InputBox("¿Qué quieres lograr con estos datos?" & vbLf & vbLf & _
            "Ejemplos: «saber qué productos y ciudades crecen más», «encontrar estudiantes en riesgo», " & _
            "«clasificar las quejas por tema». Si lo dejas vacío uso un objetivo general.", TITULO)
    End If
    objetivo = Trim$(Replace(Replace(objetivo, vbCr, " "), vbLf, " "))
    If Len(objetivo) = 0 Then objetivo = OBJETIVO_POR_DEFECTO

    d = lo.DataBodyRange.Value
    nC = UBound(d, 1)
    sep = Application.International(xlListSeparator)
    dec = Application.International(xlDecimalSeparator)
    FuncionesModernas disponibles, faltan

    ReDim L(1 To nC + 60)
    Agregar L, n, "Actúa como analista de datos experto en Excel y en Python (pandas)."
    Agregar L, n, "Te comparto la ESTRUCTURA y las ESTADÍSTICAS de una tabla de Excel, no sus filas: los datos se quedan en mi computador."
    Agregar L, n, ""
    Agregar L, n, "MI OBJETIVO"
    Agregar L, n, objetivo
    Agregar L, n, ""
    Agregar L, n, "LA TABLA"
    Agregar L, n, "- Hoja «" & wsP.Range("B4").Value & "», rango " & wsP.Range("B5").Value & ": encabezados en la primera fila, " & _
                  Format$(wsP.Range("B6").Value, "#,##0") & " filas de datos y " & wsP.Range("B7").Value & " columnas."
    Agregar L, n, "- Filas duplicadas exactas: " & Format$(wsP.Range("B8").Value, "#,##0") & ". Celdas vacías: " & wsP.Range("B9").Value & "."
    Agregar L, n, "- Mi Excel: versión " & Application.Version & IIf(EsMac(), " para Mac", " para Windows") & _
                  IIf(ExcelEnEspanol(), ", en español (nombres de funciones en español)", "") & _
                  "; separador de argumentos «" & sep & "» y separador decimal «" & dec & "»."
    If Len(disponibles) > 0 Then Agregar L, n, "- Funciones modernas disponibles: " & disponibles & "."
    If Len(faltan) > 0 Then Agregar L, n, "- NO disponibles en mi versión (no las uses): " & faltan & "."
    Agregar L, n, ""
    Agregar L, n, "COLUMNAS (nombre | tipo | con dato | vacíos | valores únicos | estadísticas | alertas)"
    For j = 1 To nC
        s = j & ". " & d(j, 1) & " | " & d(j, 2) & " | " & Format$(d(j, 3), "#,##0") & " | " & Format$(d(j, 4), "#,##0") & _
            " (" & Format$(d(j, 5), "0.0 %") & ") | " & Format$(d(j, 6), "#,##0") & " únicos"
        If Not IsEmpty(d(j, 7)) Then s = s & " | mín " & ValorPrompt(d(j, 7)) & ", máx " & ValorPrompt(d(j, 8))
        If Not IsEmpty(d(j, 9)) Then s = s & ", promedio " & ValorPrompt(d(j, 9)) & ", mediana " & ValorPrompt(d(j, 10))
        If INCLUIR_VALOR_FRECUENTE And Len(CStr(d(j, 11))) > 0 And InStr(CStr(d(j, 12)), "posible ID") = 0 Then
            s = s & " | más frecuente: " & d(j, 11)
        End If
        If Len(CStr(d(j, 12))) > 0 Then s = s & " | alertas: " & d(j, 12)
        Agregar L, n, s
    Next j
    Agregar L, n, ""
    Agregar L, n, "LO QUE NECESITO"
    Agregar L, n, "1. Diagnóstico de calidad: qué problemas ves y los pasos de limpieza en orden, cada uno en Excel (fórmula o Power Query) y en pandas."
    Agregar L, n, "2. Cinco preguntas de análisis que me ayuden a lograr mi objetivo, de mayor a menor valor."
    If Len(disponibles) > 0 Then
        s = "Prefiere las funciones modernas disponibles (" & disponibles & ") cuando simplifiquen la fórmula. "
    Else
        s = ""
    End If
    s = s & "Si no alcanzan, usa " & IIf(ExcelEnEspanol(), "SUMAR.SI.CONJUNTO, CONTAR.SI.CONJUNTO", "SUMIFS, COUNTIFS") & _
        " o una tabla dinámica. Usa las referencias reales del rango y mi separador de argumentos."
    Agregar L, n, "3. Para cada pregunta, la fórmula exacta de Excel que la responde, en qué celda va y qué resultado esperar. " & s
    Agregar L, n, "4. El código equivalente en Python con pandas, listo para ejecutar y comentado: lee el archivo con " & _
                  "pd.read_excel(""mi_archivo.xlsx"", sheet_name=""" & wsP.Range("B4").Value & """), aplica la limpieza y responde las cinco preguntas."
    Agregar L, n, "5. El gráfico más adecuado para cada pregunta y por qué."
    Agregar L, n, ""
    Agregar L, n, "REGLAS"
    Agregar L, n, "- Usa solo las columnas de arriba, con sus nombres exactos; no inventes columnas ni valores."
    Agregar L, n, "- Si te falta información para responder bien, pregúntame antes de suponer."
    Agregar L, n, "- Responde en español, con secciones numeradas y el código en bloques."
    ReDim Preserve L(1 To n)
    texto = Join(L, vbCrLf)

    ' Escribe el prompt debajo de la tabla (reemplaza el anterior)
    filaIni = lo.Range.Row + lo.Range.Rows.Count + 2
    ultima = wsP.Cells.SpecialCells(xlCellTypeLastCell).Row
    If ultima >= filaIni - 1 Then wsP.Range(wsP.Rows(filaIni - 1), wsP.Rows(ultima)).Delete
    copiado = CopiarAlPortapapeles(texto)
    With wsP.Cells(filaIni, 1)
        .Value = "Prompt para tu asistente de IA"
        .Font.Size = 14
        .Font.Bold = True
        .Font.Color = RGB(35, 80, 240)
    End With
    wsP.Cells(filaIni + 1, 1).NumberFormat = "@"
    If copiado Then
        wsP.Cells(filaIni + 1, 1).Value = "Ya está en el portapapeles: pégalo (Ctrl+V) en ChatGPT, Gemini, Copilot o Claude. No incluye tus filas, pero revísalo antes de enviarlo."
    Else
        wsP.Cells(filaIni + 1, 1).Value = "No se pudo usar el portapapeles: selecciona las celdas A" & (filaIni + 3) & ":A" & (filaIni + 2 + n) & _
                                         ", cópialas (Ctrl+C) y pégalas en tu IA."
    End If
    wsP.Cells(filaIni + 1, 1).Font.Color = RGB(96, 96, 96)
    Set rngPrompt = wsP.Range(wsP.Cells(filaIni + 3, 1), wsP.Cells(filaIni + 2 + n, 1))
    rngPrompt.NumberFormat = "@"
    ReDim celdas(1 To n, 1 To 1)
    For j = 1 To n
        celdas(j, 1) = L(j)
    Next j
    rngPrompt.Value = celdas
    rngPrompt.WrapText = False
    wsP.Range(wsP.Cells(filaIni + 3, 1), wsP.Cells(filaIni + 2 + n, 12)).Interior.Color = RGB(243, 246, 251)
    For j = 1 To n
        If Len(L(j)) > 0 And L(j) = UCase$(L(j)) Then rngPrompt.Cells(j, 1).Font.Bold = True
    Next j

    If copiado Then
        Avisar "Listo. El prompt está en la hoja «" & HOJA_PERFIL & "» y en el portapapeles." & vbLf & vbLf & _
               "Pégalo (Ctrl+V) en ChatGPT, Gemini, Copilot o Claude.", vbInformation
    Else
        Avisar "El prompt está en la hoja «" & HOJA_PERFIL & "», pero no se pudo copiar al portapapeles." & vbLf & _
               "Selecciona sus celdas, cópialas (Ctrl+C) y pégalas en tu IA.", vbExclamation
    End If
End Sub

Private Sub Agregar(L() As String, ByRef n As Long, ByVal s As String)
    n = n + 1
    If n > UBound(L) Then ReDim Preserve L(1 To n + 20)
    L(n) = s
End Sub

Private Function ValorPrompt(ByVal v As Variant) As String
    If VarType(v) = vbDate Then
        ValorPrompt = Format$(v, "dd/mm/yyyy")
    ElseIf IsNumeric(v) Then
        ValorPrompt = NumTexto(CDbl(v))
    Else
        ValorPrompt = CStr(v)
    End If
End Function

' Prueba qué funciones modernas tiene este Excel (Evaluate usa los nombres en inglés)
Private Sub FuncionesModernas(ByRef disponibles As String, ByRef faltan As String)
    Dim ingles As Variant, espanol As Variant, pruebas As Variant, i As Long, r As Variant, nombre As String
    ingles = Array("LET", "LAMBDA", "FILTER", "XLOOKUP", "GROUPBY", "PIVOTBY")
    espanol = Array("LET", "LAMBDA", "FILTRAR", "BUSCARX", "AGRUPARPOR", "PIVOTARPOR")
    pruebas = Array("=LET(x,2,x*3)", "=LAMBDA(x,x+1)(1)", "=ROWS(FILTER({1;2;3},{1;0;1}))", "=XLOOKUP(2,{1,2},{3,4})", _
                    "=ROWS(GROUPBY({1;1;2},{1;2;3},LAMBDA(x,SUM(x))))", "=ROWS(PIVOTBY({1;1;2},{1;2;1},{1;2;3},LAMBDA(x,SUM(x))))")
    For i = 0 To UBound(pruebas)
        nombre = IIf(ExcelEnEspanol(), espanol(i), ingles(i))
        On Error Resume Next
        r = Empty
        r = Application.Evaluate(pruebas(i))
        If Err.Number <> 0 Or IsError(r) Or IsEmpty(r) Then
            faltan = UnirLista(faltan, nombre)
        Else
            disponibles = UnirLista(disponibles, nombre)
        End If
        Err.Clear
        On Error GoTo 0
    Next i
End Sub

Private Function ExcelEnEspanol() As Boolean
    On Error Resume Next
    ExcelEnEspanol = (Application.LanguageSettings.LanguageID(2) Mod 1024) = 10   ' 2 = idioma de la interfaz
End Function

Private Function EsMac() As Boolean
#If Mac Then
    EsMac = True
#End If
End Function

Private Function CopiarAlPortapapeles(ByVal texto As String) As Boolean
    Dim d As Object, leido As String
    On Error Resume Next
    Set d = CreateObject("new:{1C3B4210-F441-11CE-B9EA-00AA004B9C29}")   ' MSForms.DataObject
    If Not d Is Nothing Then
        d.SetText texto
        d.PutInClipboard
        Set d = Nothing
        Set d = CreateObject("new:{1C3B4210-F441-11CE-B9EA-00AA004B9C29}")
        d.GetFromClipboard
        leido = d.GetText
        If Err.Number = 0 And leido = texto Then
            CopiarAlPortapapeles = True
            Exit Function
        End If
        Err.Clear
    End If
#If Mac Then
#Else
    ' Plan B (Windows 10/11 a veces pega «??» con DataObject): API del portapapeles
    CopiarAlPortapapeles = CopiarConApi(texto)
#End If
End Function

#If Mac Then
#Else
Private Function CopiarConApi(ByVal texto As String) As Boolean
    Dim h As LongPtr, p As LongPtr
    On Error GoTo Salir
    h = GlobalAlloc(&H42, LenB(texto) + 2)   ' GMEM_MOVEABLE Or GMEM_ZEROINIT
    If h = 0 Then Exit Function
    p = GlobalLock(h)
    If p = 0 Then Exit Function
    CopyMemory p, StrPtr(texto), LenB(texto)
    GlobalUnlock h
    If OpenClipboard(0) = 0 Then Exit Function
    EmptyClipboard
    CopiarConApi = SetClipboardData(13, h) <> 0   ' 13 = CF_UNICODETEXT
    CloseClipboard
Salir:
End Function
#End If

'==============================================================================
' 3. FUNCIONES CON IA (Google Gemini)
'==============================================================================
' =IA(instrucción; [contexto]) -> texto de la respuesta
Public Function IA(ByVal instruccion As String, Optional ByVal contexto As Variant) As String
Attribute IA.VB_Description = "Envía una instrucción (y, opcional, el contenido de una celda o rango) a Google Gemini y devuelve la respuesta."
    Dim prompt As String, ctx As String
    If Len(Trim$(instruccion)) = 0 Then
        IA = "#IA: escribe una instrucción."
        Exit Function
    End If
    If Not IsMissing(contexto) Then ctx = TextoContexto(contexto)
    prompt = instruccion
    If Len(ctx) > 0 Then prompt = prompt & vbLf & vbLf & "Datos:" & vbLf & ctx
    IA = LlamarGemini(prompt, SISTEMA_GENERAL, 0.2, MAX_TOKENS_IA)
End Function

' =IA_CLASIFICAR(texto; categorías) -> exactamente una de las categorías
Public Function IA_CLASIFICAR(ByVal texto As Variant, ByVal categorias As Variant) As String
Attribute IA_CLASIFICAR.VB_Description = "Clasifica un texto en exactamente una de las categorías (rango de celdas o texto separado por comas)."
    Dim t As String, cats() As String, nCats As Long, i As Long, prompt As String, r As String, elegida As String
    t = TextoContexto(texto)
    If Len(Trim$(t)) = 0 Then Exit Function   ' celda vacía: resultado vacío, sin consultar
    nCats = ListaCategorias(categorias, cats)
    If nCats < 2 Then
        IA_CLASIFICAR = "#IA: indica al menos dos categorías (un rango o un texto separado por comas)."
        Exit Function
    End If
    prompt = "Clasifica el texto en EXACTAMENTE una de estas categorías:" & vbLf
    For i = 1 To nCats
        prompt = prompt & "- " & cats(i) & vbLf
    Next i
    prompt = prompt & vbLf & "Texto: """ & t & """" & vbLf & vbLf & _
             "Responde solo con el nombre exacto de la categoría, tal como aparece en la lista."
    r = LlamarGemini(prompt, SISTEMA_CLASIFICAR, 0, 64)
    If Left$(r, 4) = "#IA:" Then
        IA_CLASIFICAR = r
        Exit Function
    End If
    elegida = CoincidirCategoria(r, cats, nCats)
    If Len(elegida) = 0 Then
        IA_CLASIFICAR = "#IA: respuesta fuera de categorías (" & Left$(Trim$(r), 40) & ")"
    Else
        IA_CLASIFICAR = elegida
    End If
End Function

' =IA_EXTRAER(texto; "correo") -> el dato, un número si es un monto, o "" si no aparece
Public Function IA_EXTRAER(ByVal texto As Variant, ByVal campo As String) As Variant
Attribute IA_EXTRAER.VB_Description = "Extrae un dato (correo, ciudad, monto, fecha...) de un texto libre. Devuelve vacío si no aparece."
    Dim t As String, prompt As String, r As String
    t = TextoContexto(texto)
    If Len(Trim$(t)) = 0 Then IA_EXTRAER = "": Exit Function
    If Len(Trim$(campo)) = 0 Then IA_EXTRAER = "#IA: indica qué dato extraer (por ejemplo ""correo"").": Exit Function
    prompt = "Extrae del texto el dato: " & Trim$(campo) & "." & vbLf & _
             "Reglas: responde solo con el valor, sin comillas ni explicaciones. Si es un monto, precio o cantidad, " & _
             "responde solo el número, sin símbolo de moneda ni separadores de miles y con punto decimal. " & _
             "Si es una fecha, usa el formato AAAA-MM-DD. Si el dato no aparece en el texto, responde exactamente NO_ENCONTRADO." & _
             vbLf & vbLf & "Texto: """ & t & """"
    r = LlamarGemini(prompt, SISTEMA_EXTRAER, 0, 128)
    If Left$(r, 4) = "#IA:" Then IA_EXTRAER = r: Exit Function
    r = LimpiarRespuesta(r)
    If InStr(1, r, "NO_ENCONTRADO", vbTextCompare) > 0 Or Len(r) = 0 Then
        IA_EXTRAER = ""
    ElseIf EsNumeroSimple(r) Then
        IA_EXTRAER = Val(r)   ' Val siempre usa punto decimal
    Else
        IA_EXTRAER = r
    End If
End Function

Public Sub ConfigurarIA()
Attribute ConfigurarIA.VB_Description = "Guarda o borra la clave de Google Gemini que usan las funciones IA, IA_CLASIFICAR e IA_EXTRAER."
    Dim estado As String, r As String, actual As String
    actual = ClaveIA(estado)
    If Avisar("Las funciones IA, IA_CLASIFICAR e IA_EXTRAER usan Google Gemini con TU clave personal." & vbLf & vbLf & _
              "- Consíguela gratis en https://aistudio.google.com/apikey" & vbLf & _
              "- Lo que envíes sale de tu computador hacia Google. Con el nivel gratuito, Google puede usarlo para mejorar sus productos: no envíes datos personales ni confidenciales." & vbLf & _
              "- El nivel gratuito tiene límites por minuto y por día. Si activas la facturación, cada consulta cuesta." & vbLf & _
              "- La clave queda guardada (oculta, sin cifrar) dentro de ESTE libro: no compartas el archivo con tu clave. " & _
              "Otra opción es la variable de entorno de Windows GEMINI_API_KEY." & vbLf & vbLf & _
              "Estado actual: " & estado & "." & vbLf & vbLf & "¿Continuar?", vbOKCancel + vbInformation, vbCancel) <> vbOK Then Exit Sub
    r = InputBox("Pega tu clave de Google Gemini (empieza por AIza)." & vbLf & vbLf & _
                 "Escribe BORRAR para quitar la clave guardada en este libro.", TITULO)
    r = Trim$(r)
    If Len(r) = 0 Then Exit Sub
    If UCase$(r) = "BORRAR" Then
        On Error Resume Next
        ThisWorkbook.Names(NOMBRE_CLAVE).Delete
        On Error GoTo 0
        LimpiarCache
        Avisar "Clave borrada de este libro. Guarda el libro para que el cambio sea permanente.", vbInformation
        Exit Sub
    End If
    If Len(r) < 30 Or InStr(r, " ") > 0 Or InStr(r, """") > 0 Then
        Avisar "Eso no parece una clave de Gemini. Cópiala completa desde https://aistudio.google.com/apikey", vbExclamation
        Exit Sub
    End If
    GuardarClave r
    Avisar "Clave guardada en este libro. Guárdalo como .xlsm y prueba en una celda:" & vbLf & vbLf & _
           "=IA(""Di hola en una frase"")" & vbLf & vbLf & _
           "Si tenías celdas con «#IA: falta la clave», pulsa Ctrl+Alt+F9 para recalcularlas.", vbInformation
End Sub

Public Sub LimpiarCacheIA()
Attribute LimpiarCacheIA.VB_Description = "Borra las respuestas de IA guardadas en memoria; al recalcular se vuelve a consultar a Gemini."
    Dim n As Long
    n = LimpiarCache()
    Avisar "Se borraron " & n & " respuestas guardadas en memoria." & vbLf & _
           "Las celdas conservan su valor; para volver a consultar a la IA, edítalas o pulsa Ctrl+Alt+F9.", vbInformation
End Sub

Private Function LimpiarCache() As Long
    If Not cacheIA Is Nothing Then
        LimpiarCache = cacheIA.Count
        cacheIA.RemoveAll
    End If
End Function

Private Sub GuardarClave(ByVal clave As String)
    ThisWorkbook.Names.Add Name:=NOMBRE_CLAVE, RefersTo:="=""" & clave & """", Visible:=False
    If ThisWorkbook.IsAddin Then ThisWorkbook.Save
End Sub

' Clave: primero la del libro (ConfigurarIA), luego la variable de entorno GEMINI_API_KEY
Private Function ClaveIA(Optional ByRef origen As String) As String
    Dim v As String
    On Error Resume Next
    v = ThisWorkbook.Names(NOMBRE_CLAVE).RefersTo
    If Len(v) > 3 Then
        v = Mid$(v, 3, Len(v) - 3)   ' ="AIza..." -> AIza...
        origen = "clave guardada en este libro"
    Else
        v = Environ$("GEMINI_API_KEY")
#If Mac Then
#Else
        If Len(v) = 0 Then v = CreateObject("WScript.Shell").Environment("User")("GEMINI_API_KEY")
#End If
        If Len(v) > 0 Then origen = "se usa la variable de entorno GEMINI_API_KEY" Else origen = "sin clave configurada"
    End If
    ClaveIA = Trim$(v)
End Function

Private Function LlamarGemini(ByVal prompt As String, ByVal sistema As String, ByVal temperatura As Double, _
                              ByVal maxTokens As Long) As String
#If Mac Then
    LlamarGemini = "#IA: las funciones con IA requieren Excel para Windows."
#Else
    Dim clave As String, k As String, cuerpo As String, estado As Long, respuesta As String
    Dim intento As Long, texto As String, motivo As String
    clave = ClaveIA()
    If Len(clave) = 0 Then
        LlamarGemini = "#IA: falta la clave de Gemini. Ejecuta la macro ConfigurarIA (Alt+F8)."
        Exit Function
    End If
    k = MODELO_IA & "|" & temperatura & "|" & maxTokens & "|" & sistema & "|" & prompt
    If cacheIA Is Nothing Then Set cacheIA = CreateObject("Scripting.Dictionary")
    If cacheIA.Exists(k) Then
        LlamarGemini = cacheIA(k)
        Exit Function
    End If

    cuerpo = "{""systemInstruction"":{""parts"":[{""text"":" & JsonTexto(sistema) & "}]}," & _
             """contents"":[{""role"":""user"",""parts"":[{""text"":" & JsonTexto(prompt) & "}]}]," & _
             """generationConfig"":{""temperature"":" & Replace(Format$(temperatura, "0.0#"), ",", ".") & _
             ",""maxOutputTokens"":" & maxTokens & ",""thinkingConfig"":{""thinkingBudget"":0}}}"
    For intento = 1 To 2
        If Not EnviarPost(URL_GEMINI & MODELO_IA & ":generateContent", clave, cuerpo, estado, respuesta) Then
            LlamarGemini = "#IA: sin conexión con Gemini. Revisa tu internet o el proxy de tu red."
            Exit Function
        End If
        If estado <> 429 And estado < 500 Then Exit For
        If intento = 1 Then Sleep 2000   ' un reintento ante saturación momentánea
    Next intento

    Select Case estado
        Case 200
            texto = ExtraerTextoGemini(respuesta, motivo)
            If Len(Trim$(texto)) = 0 Then
                If motivo = "SAFETY" Or motivo = "PROHIBITED_CONTENT" Or motivo = "BLOCKLIST" Then
                    LlamarGemini = "#IA: Gemini bloqueó la respuesta por sus filtros de seguridad."
                Else
                    LlamarGemini = "#IA: la respuesta llegó vacía (" & IIf(Len(motivo) > 0, motivo, "sin motivo") & ")."
                End If
                Exit Function
            End If
            texto = Trim$(texto)
            Do While Right$(texto, 1) = vbLf Or Right$(texto, 1) = vbCr
                texto = Left$(texto, Len(texto) - 1)
            Loop
            cacheIA(k) = texto
            LlamarGemini = texto
        Case 400
            If InStr(respuesta, "API_KEY_INVALID") > 0 Or InStr(1, respuesta, "API key not valid", vbTextCompare) > 0 Then
                LlamarGemini = "#IA: la clave de Gemini no es válida. Revísala con la macro ConfigurarIA."
            Else
                LlamarGemini = "#IA: Gemini rechazó la solicitud (400): " & Left$(MensajeErrorJson(respuesta), 150)
            End If
        Case 401, 403
            LlamarGemini = "#IA: la clave no tiene permiso para usar Gemini (" & estado & "). Revísala en https://aistudio.google.com/apikey"
        Case 404
            LlamarGemini = "#IA: el modelo " & MODELO_IA & " no está disponible (404). Cambia MODELO_IA en el módulo."
        Case 429
            LlamarGemini = "#IA: límite de la API alcanzado (429). Espera un minuto y pulsa Ctrl+Alt+F9; las respuestas ya obtenidas no se repiten."
        Case Is >= 500
            LlamarGemini = "#IA: Gemini no está disponible en este momento (" & estado & "). Intenta más tarde."
        Case Else
            LlamarGemini = "#IA: error " & estado & " de Gemini: " & Left$(MensajeErrorJson(respuesta), 150)
    End Select
#End If
End Function

#If Mac Then
#Else
Private Function EnviarPost(ByVal url As String, ByVal clave As String, ByVal cuerpo As String, _
                            ByRef estado As Long, ByRef respuesta As String) As Boolean
    Dim clases As Variant, i As Long, http As Object
    ' ServerXMLHTTP primero; WinHttp y XMLHTTP (usa el proxy de Windows) como respaldo
    clases = Array("MSXML2.ServerXMLHTTP.6.0", "WinHttp.WinHttpRequest.5.1", "MSXML2.XMLHTTP.6.0")
    For i = 0 To UBound(clases)
        Set http = Nothing
        On Error Resume Next
        Set http = CreateObject(clases(i))
        If Not http Is Nothing Then
            Err.Clear
            http.Open "POST", url, False
            If i < 2 Then http.SetTimeouts 10000, 10000, 30000, 60000
            http.setRequestHeader "Content-Type", "application/json; charset=utf-8"
            http.setRequestHeader "x-goog-api-key", clave   ' nunca en la URL
            http.send cuerpo
            If Err.Number = 0 Then
                estado = http.Status
                respuesta = http.responseText
                EnviarPost = True
                Exit Function
            End If
        End If
        Err.Clear
        On Error GoTo 0
    Next i
End Function
#End If

' Une candidates[0].content.parts[*].text de la respuesta JSON
Private Function ExtraerTextoGemini(ByVal json As String, ByRef motivo As String) As String
    Dim p As Long, q As Long, fin As Long, salida As String
    p = InStr(1, json, """candidates""")
    If p = 0 Then Exit Function
    q = InStr(p, json, """finishReason""")
    If q > 0 Then motivo = CadenaTrasClave(json, q + Len("""finishReason"""), fin)
    p = InStr(p, json, """parts""")
    Do While p > 0
        p = InStr(p, json, """text""")
        If p = 0 Then Exit Do
        salida = salida & CadenaTrasClave(json, p + 6, fin)
        If fin <= p Then Exit Do
        p = fin
    Loop
    ExtraerTextoGemini = salida
End Function

Private Function MensajeErrorJson(ByVal json As String) As String
    Dim p As Long, fin As Long
    p = InStr(1, json, """message""")
    If p > 0 Then MensajeErrorJson = CadenaTrasClave(json, p + 9, fin) Else MensajeErrorJson = Left$(json, 150)
End Function

' Lee la cadena JSON que sigue a una clave (desde la posición después de "clave")
Private Function CadenaTrasClave(ByVal json As String, ByVal desde As Long, ByRef fin As Long) As String
    Dim i As Long, n As Long, c As String, partes() As String, np As Long, h As String
    n = Len(json)
    i = desde
    Do While i <= n
        c = Mid$(json, i, 1)
        If c = """" Then Exit Do
        If c <> ":" And c <> " " And c <> vbTab And c <> vbCr And c <> vbLf Then fin = i: Exit Function
        i = i + 1
    Loop
    If i > n Then fin = n: Exit Function
    ReDim partes(1 To 64)
    i = i + 1
    Do While i <= n
        c = Mid$(json, i, 1)
        If c = """" Then Exit Do
        If c = "\" And i < n Then
            i = i + 1
            Select Case Mid$(json, i, 1)
                Case "n": c = vbLf
                Case "t": c = vbTab
                Case "r": c = vbCr
                Case "b": c = ChrW(8)
                Case "f": c = ChrW(12)
                Case "u"
                    h = Mid$(json, i + 1, 4)
                    c = ChrW(CLng("&H" & h) And &HFFFF&)
                    i = i + 4
                Case Else: c = Mid$(json, i, 1)   ' \" \\ \/
            End Select
        End If
        np = np + 1
        If np > UBound(partes) Then ReDim Preserve partes(1 To np * 2)
        partes(np) = c
        i = i + 1
    Loop
    fin = i
    If np > 0 Then
        ReDim Preserve partes(1 To np)
        CadenaTrasClave = Join(partes, "")
    End If
End Function

' Cadena JSON segura: escapa comillas, barras y control; lo no ASCII va como \uXXXX
Private Function JsonTexto(ByVal s As String) As String
    Dim i As Long, c As Long, partes() As String
    If Len(s) = 0 Then JsonTexto = """""": Exit Function
    ReDim partes(1 To Len(s))
    For i = 1 To Len(s)
        c = AscW(Mid$(s, i, 1)) And &HFFFF&
        Select Case c
            Case 34: partes(i) = "\"""
            Case 92: partes(i) = "\\"
            Case 10: partes(i) = "\n"
            Case 13: partes(i) = "\r"
            Case 9: partes(i) = "\t"
            Case 32 To 126: partes(i) = ChrW(c)
            Case Else: partes(i) = "\u" & Right$("000" & LCase$(Hex$(c)), 4)
        End Select
    Next i
    JsonTexto = """" & Join(partes, "") & """"
End Function

' Celda, rango, matriz o valor -> texto (filas en líneas, celdas separadas por « | »)
Private Function TextoContexto(ByVal v As Variant) As String
    Dim r As Range, a As Variant, i As Long, j As Long, filaTxt As String, s As String, dosDim As Boolean
    If IsObject(v) Then
        If TypeName(v) <> "Range" Then Exit Function
        Set r = v
        If r.Cells.CountLarge > 1 Then
            Set r = Intersect(r, r.Worksheet.UsedRange)
            If r Is Nothing Then Exit Function
        End If
        a = r.Value
    Else
        a = v
    End If
    If Not IsArray(a) Then
        TextoContexto = TextoCelda(a)
        Exit Function
    End If
    On Error Resume Next
    j = UBound(a, 2)
    dosDim = (Err.Number = 0)
    On Error GoTo 0
    If dosDim Then
        For i = LBound(a, 1) To UBound(a, 1)
            filaTxt = ""
            For j = LBound(a, 2) To UBound(a, 2)
                If j > LBound(a, 2) Then filaTxt = filaTxt & " | "
                filaTxt = filaTxt & TextoCelda(a(i, j))
            Next j
            If Len(Replace(filaTxt, " | ", "")) > 0 Then s = s & filaTxt & vbLf
            If Len(s) > MAX_CONTEXTO Then Exit For
        Next i
    Else
        For i = LBound(a) To UBound(a)
            If Len(TextoCelda(a(i))) > 0 Then s = s & TextoCelda(a(i)) & vbLf
            If Len(s) > MAX_CONTEXTO Then Exit For
        Next i
    End If
    If Len(s) > MAX_CONTEXTO Then s = Left$(s, MAX_CONTEXTO) & " [...texto recortado]"
    If Right$(s, 1) = vbLf Then s = Left$(s, Len(s) - 1)
    TextoContexto = s
End Function

Private Function ListaCategorias(ByVal categorias As Variant, ByRef cats() As String) As Long
    Dim a As Variant, item As Variant, partes() As String, i As Long, s As String, n As Long
    ReDim cats(1 To 1)
    If IsObject(categorias) Then
        If TypeName(categorias) <> "Range" Then Exit Function
        a = categorias.Value
        If Not IsArray(a) Then a = Array(a)
        For Each item In a
            s = Trim$(TextoCelda(item))
            If Len(s) > 0 Then n = n + 1: ReDim Preserve cats(1 To n): cats(n) = s
        Next item
    ElseIf IsArray(categorias) Then
        For Each item In categorias
            s = Trim$(TextoCelda(item))
            If Len(s) > 0 Then n = n + 1: ReDim Preserve cats(1 To n): cats(n) = s
        Next item
    Else
        s = TextoCelda(categorias)
        If InStr(s, ";") > 0 Then
            partes = Split(s, ";")
        ElseIf InStr(s, "|") > 0 Then
            partes = Split(s, "|")
        Else
            partes = Split(s, ",")
        End If
        For i = 0 To UBound(partes)
            If Len(Trim$(partes(i))) > 0 Then n = n + 1: ReDim Preserve cats(1 To n): cats(n) = Trim$(partes(i))
        Next i
    End If
    ListaCategorias = n
End Function

Private Function CoincidirCategoria(ByVal respuesta As String, cats() As String, ByVal nCats As Long) As String
    Dim r As String, i As Long, encontrada As Long, veces As Long
    r = Normalizar(LimpiarRespuesta(respuesta))
    For i = 1 To nCats
        If r = Normalizar(cats(i)) Then CoincidirCategoria = cats(i): Exit Function
    Next i
    ' Si la respuesta trae algo más («Categoría: Precio»), se acepta solo si contiene una sola categoría
    For i = 1 To nCats
        If InStr(1, r, Normalizar(cats(i)), vbBinaryCompare) > 0 Then veces = veces + 1: encontrada = i
    Next i
    If veces = 1 Then CoincidirCategoria = cats(encontrada)
End Function

Private Function LimpiarRespuesta(ByVal s As String) As String
    s = Replace(Replace(Replace(s, vbCr, " "), vbLf, " "), vbTab, " ")
    s = Trim$(s)
    Do While Len(s) > 0 And InStr("""'`*.«»“”", Left$(s, 1)) > 0
        s = Trim$(Mid$(s, 2))
    Loop
    Do While Len(s) > 0 And InStr("""'`*.«»“”", Right$(s, 1)) > 0
        s = Trim$(Left$(s, Len(s) - 1))
    Loop
    LimpiarRespuesta = s
End Function

' Minúsculas, sin tildes y sin espacios repetidos (para comparar categorías)
Private Function Normalizar(ByVal s As String) As String
    Dim conTilde As String, sinTilde As String, i As Long
    conTilde = "áéíóúàèìòùäëïöüâêîôûñç"
    sinTilde = "aeiouaeiouaeiouaeiounc"
    s = LCase$(Trim$(s))
    For i = 1 To Len(conTilde)
        s = Replace(s, Mid$(conTilde, i, 1), Mid$(sinTilde, i, 1))
    Next i
    Do While InStr(s, "  ") > 0
        s = Replace(s, "  ", " ")
    Loop
    Normalizar = s
End Function

Private Function EsNumeroSimple(ByVal s As String) As Boolean
    Dim i As Long, c As String, puntos As Long, digitos As Long
    If Len(s) = 0 Or Len(s) > 20 Then Exit Function
    For i = 1 To Len(s)
        c = Mid$(s, i, 1)
        If c Like "#" Then
            digitos = digitos + 1
        ElseIf c = "." Then
            puntos = puntos + 1
        ElseIf c = "-" And i = 1 Then
        Else
            Exit Function
        End If
    Next i
    EsNumeroSimple = digitos > 0 And puntos <= 1 And Right$(s, 1) <> "."
End Function

' MsgBox solo si Excel está visible (si lo controla otro programa no se bloquea)
Private Function Avisar(ByVal mensaje As String, Optional ByVal botones As VbMsgBoxStyle = vbInformation, _
                        Optional ByVal respuestaSilenciosa As VbMsgBoxResult = vbOK) As VbMsgBoxResult
    If Application.Visible Then
        Avisar = MsgBox(mensaje, botones, TITULO)
    Else
        Avisar = respuestaSilenciosa
    End If
End Function
