Attribute VB_Name = "CodigoQR"
'==============================================================================
' CodigoQR - genera codigos QR dentro de Excel (VBA puro, sin internet)
' Autor: Edwin Ortiz Herazo - https://www.edwinortiz.net/herramientas/generador-qr/
' Licencia: uso libre en tus archivos personales y de tu empresa. Se permite
' modificarlo; no se permite venderlo como producto propio.
'
' COMO FUNCION (se actualiza solo cuando cambia el texto):
'   =QR(A2)            dibuja el codigo QR de A2 dentro de la celda de la formula
'   =QR(A2; "H")       nivel de correccion: L (7%), M (15%, por defecto), Q (25%), H (30%)
'   Ajusta el alto y el ancho de la celda: el QR ocupa el cuadrado mas grande que cabe.
'
' COMO MACRO (Alt+F8):
'   GenerarQR          selecciona celdas con texto y ejecutala: el QR aparece en la
'                      celda de la derecha de cada una.
'   BorrarQR           elimina todos los QR de la hoja activa.
'
' Codifica cualquier texto o enlace (UTF-8, con tildes y emojis), versiones 1 a 40.
' Para miles de codigos o exportarlos como imagenes PNG, mira las plantillas de
' https://www.edwinortiz.net/tienda/
'
' COMO INSTALARLO: en Excel pulsa Alt+F11, menu Archivo > Importar archivo,
' elige este archivo .bas y guarda tu libro como "Libro de Excel habilitado
' para macros (*.xlsm)". Requiere Excel para Windows.
'
' EN: =QR(A2) draws the QR code of A2 inside the formula cell; =QR(A2, "H") sets the
' error correction level. Macros: GenerarQR (selected cells -> QR in the next column)
' and BorrarQR (deletes them). Import with Alt+F11 > File > Import File.
'==============================================================================
Option Explicit

Private Const PREFIJO As String = "QR_"
Private Const ESCALA As Long = 8      ' pixeles por modulo en la imagen
Private Const MARGEN As Long = 4      ' zona en blanco alrededor (modulos)
Private Const ALNUM As String = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ $%*+-./:"

Private EXPT(0 To 511) As Long, LOGT(0 To 255) As Long
Private P2(0 To 30) As Long
Private eccPorBloque(0 To 3, 1 To 40) As Long, numBloques(0 To 3, 1 To 40) As Long
Private listo As Boolean

Private mods() As Boolean, fnm() As Boolean, tam As Long
Private bits() As Byte, nbits As Long

'------------------------------------------------------------------------------
' Uso desde la hoja
'------------------------------------------------------------------------------
Public Function QR(ByVal texto As Variant, Optional ByVal nivel As String = "M") As Variant
Attribute QR.VB_Description = "Dibuja el codigo QR del texto dentro de esta celda. Nivel: L, M, Q o H."
    Dim celda As Range
    On Error GoTo Fallo
    Set celda = Application.Caller
    If IsError(texto) Then QR = texto: Exit Function
    If CStr(texto) = "" Then
        BorrarImagen celda
        QR = ""
        Exit Function
    End If
    If Not DibujarEnCelda(celda, CStr(texto), nivel) Then QR = CVErr(xlErrValue): Exit Function
    QR = ""
    Exit Function
Fallo:
    QR = CVErr(xlErrValue)
End Function

Public Sub GenerarQR()
Attribute GenerarQR.VB_Description = "Crea el codigo QR de cada celda seleccionada en la celda de la derecha."
    Dim c As Range, n As Long, malos As Long
    If TypeName(Selection) <> "Range" Then
        If Application.Interactive Then MsgBox "Selecciona primero las celdas que tienen el texto o el enlace.", vbInformation, "Generar QR"
        Exit Sub
    End If
    Application.ScreenUpdating = False
    For Each c In Intersect(Selection, Selection.Worksheet.UsedRange).Cells
        If Not IsError(c.Value) Then
            If CStr(c.Value) <> "" Then
                If DibujarEnCelda(c.Offset(0, 1), CStr(c.Value), "M") Then n = n + 1 Else malos = malos + 1
            End If
        End If
    Next
    Application.ScreenUpdating = True
    If Application.Interactive Then MsgBox n & " codigo(s) QR creado(s)" & IIf(malos > 0, "; " & malos & " texto(s) demasiado largo(s).", "."), vbInformation, "Generar QR"
End Sub

Public Sub BorrarQR()
Attribute BorrarQR.VB_Description = "Elimina de la hoja activa los codigos QR creados por este modulo."
    Dim i As Long
    For i = ActiveSheet.Shapes.Count To 1 Step -1
        If Left(ActiveSheet.Shapes(i).Name, Len(PREFIJO)) = PREFIJO Then ActiveSheet.Shapes(i).Delete
    Next
End Sub

' Matriz del QR como texto ("1" oscuro, "0" claro, filas separadas por "/").
' Util para revisar el resultado o dibujarlo con formato condicional.
Public Function QR_MATRIZ(ByVal texto As String, Optional ByVal nivel As String = "M") As Variant
    Dim s As String, x As Long, y As Long
    If Not Codificar(texto, nivel) Then QR_MATRIZ = CVErr(xlErrValue): Exit Function
    For y = 0 To tam - 1
        If y > 0 Then s = s & "/"
        For x = 0 To tam - 1
            s = s & IIf(mods(y, x), "1", "0")
        Next
    Next
    QR_MATRIZ = s
End Function

'------------------------------------------------------------------------------
' Dibujo: imagen BMP monocromatica insertada sobre la celda
'------------------------------------------------------------------------------
Private Function DibujarEnCelda(ByVal celda As Range, ByVal texto As String, ByVal nivel As String) As Boolean
    Dim ruta As String, lado As Double, img As Shape
    If Not Codificar(texto, nivel) Then Exit Function
    ruta = Environ$("TEMP") & "\qr_edwinortiz_" & Format(Timer * 1000, "0") & ".bmp"
    EscribirBmp ruta
    BorrarImagen celda
    lado = celda.MergeArea.Width
    If celda.MergeArea.Height < lado Then lado = celda.MergeArea.Height
    lado = lado - 2
    If lado < 10 Then lado = 10
    Set img = celda.Worksheet.Shapes.AddPicture(ruta, msoFalse, msoTrue, _
        celda.MergeArea.Left + (celda.MergeArea.Width - lado) / 2, _
        celda.MergeArea.Top + (celda.MergeArea.Height - lado) / 2, lado, lado)
    img.Name = NombreImagen(celda)
    img.Placement = xlMoveAndSize
    img.AlternativeText = texto
    On Error Resume Next
    Kill ruta
    DibujarEnCelda = True
End Function

Private Function NombreImagen(ByVal celda As Range) As String
    NombreImagen = PREFIJO & celda.Address(False, False)
End Function

Private Sub BorrarImagen(ByVal celda As Range)
    On Error Resume Next
    celda.Worksheet.Shapes(NombreImagen(celda)).Delete
End Sub

Private Sub EscribirBmp(ByVal ruta As String)
    Dim lado As Long, fila As Long, bytesFila As Long, tamDatos As Long, f As Integer
    Dim x As Long, y As Long, mx As Long, my As Long, i As Long, b() As Byte, cab(0 To 61) As Byte
    lado = (tam + 2 * MARGEN) * ESCALA
    bytesFila = ((lado + 31) \ 32) * 4
    tamDatos = bytesFila * lado
    ReDim b(0 To tamDatos - 1)
    ' 1 = blanco, 0 = negro (paleta: indice 0 negro, indice 1 blanco)
    For i = 0 To tamDatos - 1: b(i) = 255: Next
    For y = 0 To lado - 1
        my = y \ ESCALA - MARGEN
        fila = (lado - 1 - y) * bytesFila          ' BMP guarda las filas de abajo hacia arriba
        For x = 0 To lado - 1
            mx = x \ ESCALA - MARGEN
            If mx >= 0 And my >= 0 And mx < tam And my < tam Then
                If mods(my, mx) Then
                    b(fila + x \ 8) = b(fila + x \ 8) And (Not P2(7 - (x And 7)) And 255)
                End If
            End If
        Next
    Next
    ' Cabeceras BITMAPFILEHEADER (14) + BITMAPINFOHEADER (40) + paleta (8)
    cab(0) = 66: cab(1) = 77                   ' "BM"
    PonerLong cab, 2, 62 + tamDatos
    PonerLong cab, 10, 62
    PonerLong cab, 14, 40
    PonerLong cab, 18, lado
    PonerLong cab, 22, lado
    cab(26) = 1: cab(28) = 1
    PonerLong cab, 34, tamDatos
    PonerLong cab, 38, 2835: PonerLong cab, 42, 2835
    PonerLong cab, 46, 2
    ' paleta: negro (0,0,0,0) y blanco (255,255,255,0)
    cab(58) = 255: cab(59) = 255: cab(60) = 255
    f = FreeFile
    Open ruta For Binary Access Write As #f
    Put #f, 1, cab
    Put #f, 63, b
    Close #f
End Sub

Private Sub PonerLong(cab() As Byte, ByVal pos As Long, ByVal v As Long)
    cab(pos) = v And 255
    cab(pos + 1) = (v \ 256) And 255
    cab(pos + 2) = (v \ 65536) And 255
    cab(pos + 3) = (v \ 16777216) And 255
End Sub

'------------------------------------------------------------------------------
' Codificador QR (ISO/IEC 18004): modos numerico, alfanumerico y bytes (UTF-8)
'------------------------------------------------------------------------------
Private Sub Iniciar()
    Dim i As Long, x As Long, filas As Variant, e As Long, v As Long, t As Variant
    If listo Then Exit Sub
    P2(0) = 1
    For i = 1 To 30: P2(i) = P2(i - 1) * 2: Next
    x = 1
    For i = 0 To 254
        EXPT(i) = x
        LOGT(x) = i
        x = x * 2
        If x And 256 Then x = x Xor &H11D
    Next
    For i = 255 To 511: EXPT(i) = EXPT(i - 255): Next

    filas = Array( _
        "7,10,15,20,26,18,20,24,30,18,20,24,26,30,22,24,28,30,28,28,28,28,30,30,26,28,30,30,30,30,30,30,30,30,30,30,30,30,30,30", _
        "10,16,26,18,24,16,18,22,22,26,30,22,22,24,24,28,28,26,26,26,26,28,28,28,28,28,28,28,28,28,28,28,28,28,28,28,28,28,28,28", _
        "13,22,18,26,18,24,18,22,20,24,28,26,24,20,30,24,28,28,26,30,28,30,30,30,30,28,30,30,30,30,30,30,30,30,30,30,30,30,30,30", _
        "17,28,22,16,22,28,26,26,24,28,24,28,22,24,24,30,28,28,26,28,30,24,30,30,30,30,30,30,30,30,30,30,30,30,30,30,30,30,30,30")
    For e = 0 To 3
        t = Split(filas(e), ",")
        For v = 1 To 40: eccPorBloque(e, v) = CLng(t(v - 1)): Next
    Next
    filas = Array( _
        "1,1,1,1,1,2,2,2,2,4,4,4,4,4,6,6,6,6,7,8,8,9,9,10,12,12,12,13,14,15,16,17,18,19,19,20,21,22,24,25", _
        "1,1,1,2,2,4,4,4,5,5,5,8,9,9,10,10,11,13,14,16,17,17,18,20,21,23,25,26,28,29,31,33,35,37,38,40,43,45,47,49", _
        "1,1,2,2,4,4,6,6,8,8,8,10,12,16,12,17,16,18,21,20,23,23,25,27,29,34,34,35,38,40,43,45,48,51,53,56,59,62,65,68", _
        "1,1,2,4,4,4,5,6,8,8,11,11,16,16,18,16,19,21,25,25,25,34,30,32,35,37,40,42,45,48,51,54,57,60,63,66,70,74,77,81")
    For e = 0 To 3
        t = Split(filas(e), ",")
        For v = 1 To 40: numBloques(e, v) = CLng(t(v - 1)): Next
    Next
    listo = True
End Sub

Private Function GfMul(ByVal a As Long, ByVal b As Long) As Long
    If a = 0 Or b = 0 Then GfMul = 0 Else GfMul = EXPT(LOGT(a) + LOGT(b))
End Function

Private Function NivelIndice(ByVal nivel As String) As Long
    Select Case UCase(Trim(nivel))
        Case "L": NivelIndice = 0
        Case "M", "": NivelIndice = 1
        Case "Q": NivelIndice = 2
        Case "H": NivelIndice = 3
        Case Else: NivelIndice = -1
    End Select
End Function

Private Function ModulosDatos(ByVal ver As Long) As Long
    Dim n As Long, a As Long
    n = (16 * ver + 128) * ver + 64
    If ver >= 2 Then
        a = ver \ 7 + 2
        n = n - ((25 * a - 10) * a - 55)
        If ver >= 7 Then n = n - 36
    End If
    ModulosDatos = n
End Function

Private Function PalabrasDatos(ByVal ver As Long, ByVal e As Long) As Long
    PalabrasDatos = ModulosDatos(ver) \ 8 - eccPorBloque(e, ver) * numBloques(e, ver)
End Function

Private Function BitsConteo(ByVal modo As Long, ByVal ver As Long) As Long
    Dim g As Long
    If ver <= 9 Then
        g = 0
    ElseIf ver <= 26 Then
        g = 1
    Else
        g = 2
    End If
    Select Case modo
        Case 1: BitsConteo = Choose(g + 1, 10, 12, 14)
        Case 2: BitsConteo = Choose(g + 1, 9, 11, 13)
        Case Else: BitsConteo = Choose(g + 1, 8, 16, 16)
    End Select
End Function

Private Sub Agregar(ByVal valor As Long, ByVal largo As Long)
    Dim i As Long
    If nbits + largo > UBound(bits) + 1 Then ReDim Preserve bits(0 To (nbits + largo) * 2)
    For i = largo - 1 To 0 Step -1
        bits(nbits) = (valor \ P2(i)) And 1
        nbits = nbits + 1
    Next
End Sub

' Bytes UTF-8 del texto (VBA guarda UTF-16)
Private Function Utf8(ByVal s As String) As Byte()
    Dim out() As Byte, n As Long, i As Long, c As Long, c2 As Long
    ReDim out(0 To Len(s) * 4 + 1)
    i = 1
    Do While i <= Len(s)
        c = AscW(Mid(s, i, 1)) And &HFFFF&
        If c >= &HD800& And c <= &HDBFF& And i < Len(s) Then
            c2 = AscW(Mid(s, i + 1, 1)) And &HFFFF&
            If c2 >= &HDC00& And c2 <= &HDFFF& Then
                c = &H10000 + (c - &HD800&) * 1024 + (c2 - &HDC00&)
                i = i + 1
            End If
        End If
        If c < &H80& Then
            out(n) = c: n = n + 1
        ElseIf c < &H800& Then
            out(n) = &HC0 Or (c \ 64): out(n + 1) = &H80 Or (c And 63): n = n + 2
        ElseIf c < &H10000 Then
            out(n) = &HE0 Or (c \ 4096): out(n + 1) = &H80 Or ((c \ 64) And 63): out(n + 2) = &H80 Or (c And 63): n = n + 3
        Else
            out(n) = &HF0 Or (c \ 262144): out(n + 1) = &H80 Or ((c \ 4096) And 63)
            out(n + 2) = &H80 Or ((c \ 64) And 63): out(n + 3) = &H80 Or (c And 63): n = n + 4
        End If
        i = i + 1
    Loop
    ReDim Preserve out(0 To n - 1)
    Utf8 = out
End Function

Private Function Codificar(ByVal texto As String, ByVal nivel As String) As Boolean
    Dim e As Long, modo As Long, cuenta As Long, i As Long, ver As Long, cc As Long
    Dim segBits() As Byte, segN As Long, by() As Byte, a As Long
    Iniciar
    e = NivelIndice(nivel)
    If e < 0 Then Exit Function

    ' Segmento de datos
    ReDim bits(0 To 255): nbits = 0
    If SoloNumeros(texto) Then
        modo = 1: cuenta = Len(texto)
        For i = 1 To Len(texto) Step 3
            Agregar CLng(Mid(texto, i, 3)), Len(Mid(texto, i, 3)) * 3 + 1
        Next
    ElseIf EsAlfanumerico(texto) Then
        modo = 2: cuenta = Len(texto)
        For i = 1 To Len(texto) Step 2
            a = InStr(ALNUM, Mid(texto, i, 1)) - 1
            If i + 1 <= Len(texto) Then
                Agregar a * 45 + InStr(ALNUM, Mid(texto, i + 1, 1)) - 1, 11
            Else
                Agregar a, 6
            End If
        Next
    Else
        modo = 4
        by = Utf8(texto)
        cuenta = 0
        If Len(texto) > 0 Then
            cuenta = UBound(by) + 1
            For i = 0 To UBound(by): Agregar by(i), 8: Next
        End If
    End If
    segBits = bits: segN = nbits

    ' Version mas pequena en la que cabe
    For ver = 1 To 40
        cc = BitsConteo(modo, ver)
        If cuenta < P2(cc) And 4 + cc + segN <= PalabrasDatos(ver, e) * 8 Then Exit For
    Next
    If ver > 40 Then Exit Function

    Dim palabras() As Long
    palabras = ConstruirPalabras(modo, cuenta, segBits, segN, ver, e)

    tam = ver * 4 + 17
    ReDim mods(0 To tam - 1, 0 To tam - 1)
    ReDim fnm(0 To tam - 1, 0 To tam - 1)
    DibujarPatrones ver
    ColocarDatos palabras

    Dim mejor As Long, elegida As Long, k As Long, p As Long
    mejor = 2147483647
    For k = 0 To 7
        AplicarMascara k
        DibujarFormato e, k
        p = Penalizacion()
        If p < mejor Then mejor = p: elegida = k
        AplicarMascara k
    Next
    AplicarMascara elegida
    DibujarFormato e, elegida
    Codificar = True
End Function

Private Function SoloNumeros(ByVal s As String) As Boolean
    Dim i As Long
    For i = 1 To Len(s)
        If Mid(s, i, 1) < "0" Or Mid(s, i, 1) > "9" Then Exit Function
    Next
    SoloNumeros = True
End Function

Private Function EsAlfanumerico(ByVal s As String) As Boolean
    Dim i As Long
    For i = 1 To Len(s)
        If InStr(1, ALNUM, Mid(s, i, 1), vbBinaryCompare) = 0 Then Exit Function
    Next
    EsAlfanumerico = True
End Function

Private Function ConstruirPalabras(ByVal modo As Long, ByVal cuenta As Long, segBits() As Byte, ByVal segN As Long, _
                                   ByVal ver As Long, ByVal e As Long) As Long()
    Dim capacidad As Long, i As Long, pad As Long, datos() As Long
    capacidad = PalabrasDatos(ver, e) * 8
    ReDim bits(0 To capacidad + 16): nbits = 0
    Agregar modo, 4
    Agregar cuenta, BitsConteo(modo, ver)
    For i = 0 To segN - 1
        bits(nbits) = segBits(i): nbits = nbits + 1
    Next
    i = capacidad - nbits: If i > 4 Then i = 4
    Agregar 0, i
    Agregar 0, (8 - (nbits Mod 8)) Mod 8
    pad = &HEC
    Do While nbits < capacidad
        Agregar pad, 8
        pad = pad Xor &HEC Xor &H11
    Loop
    ReDim datos(0 To capacidad \ 8 - 1)
    For i = 0 To nbits - 1
        If bits(i) Then datos(i \ 8) = datos(i \ 8) Or P2(7 - (i Mod 8))
    Next

    ' Bloques, correccion de errores (Reed-Solomon) e intercalado
    Dim nb As Long, eccLen As Long, crudas As Long, cortos As Long, largoCorto As Long
    Dim divisor() As Long, b As Long, k As Long, largo As Long, j As Long, n As Long
    nb = numBloques(e, ver)
    eccLen = eccPorBloque(e, ver)
    crudas = ModulosDatos(ver) \ 8
    cortos = nb - (crudas Mod nb)
    largoCorto = crudas \ nb - eccLen
    divisor = DivisorRS(eccLen)

    Dim bloques() As Long, ecc() As Long, largos() As Long, resto() As Long
    ReDim bloques(0 To nb - 1, 0 To largoCorto)
    ReDim ecc(0 To nb - 1, 0 To eccLen - 1)
    ReDim largos(0 To nb - 1)
    k = 0
    For b = 0 To nb - 1
        largo = largoCorto + IIf(b < cortos, 0, 1)
        largos(b) = largo
        For j = 0 To largo - 1: bloques(b, j) = datos(k + j): Next
        resto = RestoRS(datos, k, largo, divisor)
        For j = 0 To eccLen - 1: ecc(b, j) = resto(j): Next
        k = k + largo
    Next

    Dim salida() As Long
    ReDim salida(0 To crudas - 1)
    n = 0
    For j = 0 To largoCorto
        For b = 0 To nb - 1
            If j < largos(b) Then salida(n) = bloques(b, j): n = n + 1
        Next
    Next
    For j = 0 To eccLen - 1
        For b = 0 To nb - 1
            salida(n) = ecc(b, j): n = n + 1
        Next
    Next
    ConstruirPalabras = salida
End Function

Private Function DivisorRS(ByVal grado As Long) As Long()
    Dim poly() As Long, raiz As Long, i As Long, j As Long
    ReDim poly(0 To grado - 1)
    poly(grado - 1) = 1
    raiz = 1
    For i = 0 To grado - 1
        For j = 0 To grado - 1
            poly(j) = GfMul(poly(j), raiz)
            If j + 1 < grado Then poly(j) = poly(j) Xor poly(j + 1)
        Next
        raiz = GfMul(raiz, 2)
    Next
    DivisorRS = poly
End Function

Private Function RestoRS(datos() As Long, ByVal inicio As Long, ByVal largo As Long, divisor() As Long) As Long()
    Dim n As Long, r() As Long, i As Long, j As Long, factor As Long
    n = UBound(divisor) + 1
    ReDim r(0 To n - 1)
    For i = inicio To inicio + largo - 1
        factor = datos(i) Xor r(0)
        For j = 0 To n - 2: r(j) = r(j + 1): Next
        r(n - 1) = 0
        For j = 0 To n - 1: r(j) = r(j) Xor GfMul(divisor(j), factor): Next
    Next
    RestoRS = r
End Function

'------------------------------------------------------------------------------
' Matriz
'------------------------------------------------------------------------------
Private Sub Fijar(ByVal x As Long, ByVal y As Long, ByVal oscuro As Boolean)
    mods(y, x) = oscuro
    fnm(y, x) = True
End Sub

Private Sub DibujarPatrones(ByVal ver As Long)
    Dim i As Long, dx As Long, dy As Long, x As Long, y As Long, d As Long, c As Long
    Dim cx As Variant, cy As Variant
    For i = 0 To tam - 1
        Fijar 6, i, (i Mod 2 = 0)
        Fijar i, 6, (i Mod 2 = 0)
    Next
    cx = Array(3, tam - 4, 3)
    cy = Array(3, 3, tam - 4)
    For c = 0 To 2
        For dy = -4 To 4
            For dx = -4 To 4
                x = cx(c) + dx: y = cy(c) + dy
                If x >= 0 And y >= 0 And x < tam And y < tam Then
                    d = IIf(Abs(dx) > Abs(dy), Abs(dx), Abs(dy))
                    Fijar x, y, (d <> 2 And d <> 4)
                End If
            Next
        Next
    Next
    ' Patrones de alineacion
    If ver > 1 Then
        Dim cnt As Long, paso As Long, pos() As Long, p As Long, a As Long, bb As Long
        cnt = ver \ 7 + 2
        paso = ((ver * 8 + cnt * 3 + 5) \ (cnt * 4 - 4)) * 2
        ReDim pos(0 To cnt - 1)
        pos(0) = 6
        p = ver * 4 + 10
        For i = cnt - 1 To 1 Step -1
            pos(i) = p
            p = p - paso
        Next
        For a = 0 To cnt - 1
            For bb = 0 To cnt - 1
                If Not ((a = 0 And bb = 0) Or (a = 0 And bb = cnt - 1) Or (a = cnt - 1 And bb = 0)) Then
                    For dy = -2 To 2
                        For dx = -2 To 2
                            d = IIf(Abs(dx) > Abs(dy), Abs(dx), Abs(dy))
                            Fijar pos(bb) + dx, pos(a) + dy, (d <> 1)
                        Next
                    Next
                End If
            Next
        Next
    End If
    DibujarFormato 0, 0
    ' Informacion de version (7 en adelante)
    If ver >= 7 Then
        Dim r As Long, vbits As Long, oscuro As Boolean
        r = ver
        For i = 0 To 11
            r = (r * 2) Xor ((r \ 2048) * &H1F25&)
        Next
        vbits = ver * 4096 Or r
        For i = 0 To 17
            oscuro = ((vbits \ P2(i)) And 1) = 1
            Fijar tam - 11 + (i Mod 3), i \ 3, oscuro
            Fijar i \ 3, tam - 11 + (i Mod 3), oscuro
        Next
    End If
End Sub

Private Sub DibujarFormato(ByVal e As Long, ByVal mascara As Long)
    Dim datos As Long, r As Long, i As Long, v As Long
    datos = Choose(e + 1, 1, 0, 3, 2) * 8 Or mascara
    r = datos
    For i = 0 To 9
        r = (r * 2) Xor ((r \ 512) * &H537&)
    Next
    v = (datos * 1024 Or r) Xor &H5412&
    For i = 0 To 5: Fijar 8, i, Bit(v, i): Next
    Fijar 8, 7, Bit(v, 6)
    Fijar 8, 8, Bit(v, 7)
    Fijar 7, 8, Bit(v, 8)
    For i = 9 To 14: Fijar 14 - i, 8, Bit(v, i): Next
    For i = 0 To 7: Fijar tam - 1 - i, 8, Bit(v, i): Next
    For i = 8 To 14: Fijar 8, tam - 15 + i, Bit(v, i): Next
    Fijar 8, tam - 8, True
End Sub

Private Function Bit(ByVal v As Long, ByVal i As Long) As Boolean
    Bit = ((v \ P2(i)) And 1) = 1
End Function

Private Sub ColocarDatos(palabras() As Long)
    Dim derecha As Long, v As Long, j As Long, x As Long, y As Long, i As Long, total As Long, arriba As Boolean
    total = (UBound(palabras) + 1) * 8
    derecha = tam - 1
    Do While derecha >= 1
        If derecha = 6 Then derecha = 5
        arriba = ((derecha + 1) And 2) = 0
        For v = 0 To tam - 1
            y = IIf(arriba, tam - 1 - v, v)
            For j = 0 To 1
                x = derecha - j
                If Not fnm(y, x) Then
                    If i < total Then mods(y, x) = ((palabras(i \ 8) \ P2(7 - (i And 7))) And 1) = 1
                    i = i + 1
                End If
            Next
        Next
        derecha = derecha - 2
    Loop
End Sub

Private Function Mascara(ByVal k As Long, ByVal x As Long, ByVal y As Long) As Boolean
    Select Case k
        Case 0: Mascara = (x + y) Mod 2 = 0
        Case 1: Mascara = y Mod 2 = 0
        Case 2: Mascara = x Mod 3 = 0
        Case 3: Mascara = (x + y) Mod 3 = 0
        Case 4: Mascara = ((x \ 3) + (y \ 2)) Mod 2 = 0
        Case 5: Mascara = ((x * y) Mod 2) + ((x * y) Mod 3) = 0
        Case 6: Mascara = (((x * y) Mod 2) + ((x * y) Mod 3)) Mod 2 = 0
        Case 7: Mascara = (((x + y) Mod 2) + ((x * y) Mod 3)) Mod 2 = 0
    End Select
End Function

Private Sub AplicarMascara(ByVal k As Long)
    Dim x As Long, y As Long
    For y = 0 To tam - 1
        For x = 0 To tam - 1
            If Not fnm(y, x) Then
                If Mascara(k, x, y) Then mods(y, x) = Not mods(y, x)
            End If
        Next
    Next
End Sub

Private Function Celda(ByVal x As Long, ByVal y As Long, ByVal col As Long) As Boolean
    If col = 0 Then Celda = mods(y, x) Else Celda = mods(x, y)
End Function

Private Function Penalizacion() As Long
    Dim puntos As Long, oscuros As Long, col As Long, x As Long, y As Long, k As Long
    Dim racha As Long, previo As Boolean, hayPrevio As Boolean, c As Boolean, v As Boolean
    Dim a As Boolean, b As Boolean, p1 As Variant, p2_ As Variant, total As Long
    p1 = Array(True, False, True, True, True, False, True, False, False, False, False)
    p2_ = Array(False, False, False, False, True, False, True, True, True, False, True)
    For col = 0 To 1
        For y = 0 To tam - 1
            racha = 0: hayPrevio = False
            For x = 0 To tam - 1
                c = Celda(x, y, col)
                If col = 0 And c Then oscuros = oscuros + 1
                If hayPrevio And c = previo Then
                    racha = racha + 1
                Else
                    If racha >= 5 Then puntos = puntos + racha - 2
                    racha = 1: previo = c: hayPrevio = True
                End If
                If x + 11 <= tam Then
                    a = True: b = True
                    For k = 0 To 10
                        v = Celda(x + k, y, col)
                        If v <> p1(k) Then a = False
                        If v <> p2_(k) Then b = False
                        If Not a And Not b Then Exit For
                    Next
                    If a Then puntos = puntos + 40
                    If b Then puntos = puntos + 40
                End If
            Next
            If racha >= 5 Then puntos = puntos + racha - 2
        Next
    Next
    For y = 0 To tam - 2
        For x = 0 To tam - 2
            c = mods(y, x)
            If c = mods(y, x + 1) And c = mods(y + 1, x) And c = mods(y + 1, x + 1) Then puntos = puntos + 3
        Next
    Next
    total = tam * tam
    k = -Int(-(Abs(oscuros * 20 - total * 10) / total)) - 1
    If k > 0 Then puntos = puntos + k * 10
    Penalizacion = puntos
End Function
