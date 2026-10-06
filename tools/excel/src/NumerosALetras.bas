Attribute VB_Name = "NumerosALetras"
'==============================================================================
' NumerosALetras - convierte numeros a letras dentro de Excel (VBA, sin internet)
' Autor: Edwin Ortiz Herazo - https://www.edwinortiz.net/herramientas/numero-a-letras/
' Licencia: uso libre en tus archivos personales y de tu empresa. Se permite
' modificarlo; no se permite venderlo como producto propio.
'
' FUNCIONES (escribelas en cualquier celda, como =SUMA):
'   =NUMEROALETRAS(A2)               -> "un millon doscientos mil"
'   =NUMEROALETRAS(A2; VERDADERO)    -> "UN MILLON DOSCIENTOS MIL PESOS M/CTE"
'   =NUMEROALETRAS(A2; FALSO; 0)     -> sin decimales (redondea)
'   =NUMBERTOWORDS(A2)               -> "one million two hundred thousand"
'   =NUMBERTOWORDS(A2; TRUE)         -> "One million two hundred thousand dollars"
'
' El valor puede ser un numero o un texto ("1.250.000,50"). Maximo:
' 999 billones (999.999.999.999.999). Los centavos se redondean a 2 cifras.
' Si el valor no es valido, la funcion devuelve #VALOR!.
'
' COMO INSTALARLO: en Excel pulsa Alt+F11, menu Archivo > Importar archivo,
' elige este archivo .bas y guarda tu libro como "Libro de Excel habilitado
' para macros (*.xlsm)".
'
' EN: =NUMBERTOWORDS(A2) writes a value in English words; =NUMBERTOWORDS(A2, TRUE) adds
' dollars and cents. Import with Alt+F11 > File > Import File and save as .xlsm.
'==============================================================================
Option Explicit

Private esUnits As Variant, esTens As Variant, esHundreds As Variant
Private enOnes As Variant, enTens As Variant
Private ready As Boolean

' Las tildes se escriben con ChrW para que el modulo funcione en cualquier
' configuracion regional (~a = a con tilde, ~e, ~i, ~o, ~u).
Private Function Tx(ByVal s As String) As String
    s = Replace(s, "~a", ChrW(225))
    s = Replace(s, "~e", ChrW(233))
    s = Replace(s, "~i", ChrW(237))
    s = Replace(s, "~o", ChrW(243))
    Tx = Replace(s, "~u", ChrW(250))
End Function

Private Sub Init()
    If ready Then Exit Sub
    esUnits = Split(Tx(",uno,dos,tres,cuatro,cinco,seis,siete,ocho,nueve,diez,once,doce,trece,catorce,quince," & _
        "diecis~eis,diecisiete,dieciocho,diecinueve,veinte,veintiuno,veintid~os,veintitr~es,veinticuatro," & _
        "veinticinco,veintis~eis,veintisiete,veintiocho,veintinueve"), ",")
    esTens = Split(",,,treinta,cuarenta,cincuenta,sesenta,setenta,ochenta,noventa", ",")
    esHundreds = Split(",ciento,doscientos,trescientos,cuatrocientos,quinientos,seiscientos,setecientos,ochocientos,novecientos", ",")
    enOnes = Split("zero,one,two,three,four,five,six,seven,eight,nine,ten,eleven,twelve,thirteen,fourteen," & _
        "fifteen,sixteen,seventeen,eighteen,nineteen", ",")
    enTens = Split(",,twenty,thirty,forty,fifty,sixty,seventy,eighty,ninety", ",")
    ready = True
End Sub

'------------------------------------------------------------------------------
' Funciones publicas
'------------------------------------------------------------------------------
Public Function NUMEROALETRAS(ByVal valor As Variant, Optional ByVal pesos As Boolean = False, _
                              Optional ByVal decimales As Integer = 2) As Variant
Attribute NUMEROALETRAS.VB_Description = "Convierte un numero a letras en espanol. pesos=VERDADERO agrega PESOS M/CTE."
    On Error GoTo Invalido
    Init
    Dim negativo As Boolean, entero As Variant, fraccion As Variant, digitos As Integer
    If decimales < 0 Or decimales > 15 Then GoTo Invalido
    digitos = IIf(pesos, 2, decimales)
    If Not Normalizar(valor, "es", digitos, negativo, entero, fraccion) Then GoTo Invalido

    Dim s As String
    If pesos Then
        s = EsEntero(entero, True)
        If entero > 0 And Residuo(entero, CDec(1000000)) = 0 Then
            s = s & " de pesos"
        ElseIf entero = 1 Then
            s = s & " peso"
        Else
            s = s & " pesos"
        End If
        If fraccion > 0 Then s = s & " con " & EsEntero(fraccion, True) & IIf(fraccion = 1, " centavo", " centavos")
        NUMEROALETRAS = UCase(IIf(negativo, "menos ", "") & s & " m/cte")
        Exit Function
    End If
    s = EsEntero(entero, False)
    If fraccion > 0 Then s = s & " con " & EsEntero(fraccion, False)
    NUMEROALETRAS = IIf(negativo, "menos ", "") & s
    Exit Function
Invalido:
    NUMEROALETRAS = CVErr(xlErrValue)
End Function

Public Function NUMBERTOWORDS(ByVal value As Variant, Optional ByVal dollars As Boolean = False, _
                              Optional ByVal decimals As Integer = 2) As Variant
Attribute NUMBERTOWORDS.VB_Description = "Converts a number to English words. dollars=TRUE adds dollars and cents."
    On Error GoTo Invalid
    Init
    Dim negative As Boolean, whole As Variant, frac As Variant, digits As Integer
    If decimals < 0 Or decimals > 15 Then GoTo Invalid
    digits = IIf(dollars, 2, decimals)
    If Not Normalizar(value, "en", digits, negative, whole, frac) Then GoTo Invalid

    Dim s As String
    s = EnEntero(whole)
    If dollars Then
        s = s & IIf(whole = 1, " dollar", " dollars")
        If frac > 0 Then s = s & " and " & EnEntero(frac) & IIf(frac = 1, " cent", " cents")
        s = IIf(negative, "minus ", "") & s
        NUMBERTOWORDS = UCase(Left(s, 1)) & Mid(s, 2)
        Exit Function
    End If
    If frac > 0 Then s = s & " and " & Right(String(digits, "0") & Format(frac, "0"), digits) & "/1" & String(digits, "0")
    NUMBERTOWORDS = IIf(negative, "minus ", "") & s
    Exit Function
Invalid:
    NUMBERTOWORDS = CVErr(xlErrValue)
End Function

'------------------------------------------------------------------------------
' Lectura del valor: entero y fraccion como Decimal (28 cifras exactas)
'------------------------------------------------------------------------------
Private Function Normalizar(ByVal v As Variant, ByVal lang As String, ByVal digitos As Integer, _
                            negativo As Boolean, entero As Variant, fraccion As Variant) As Boolean
    Dim signo As String, intDigits As String, fracDigits As String
    ' Desde una celda Excel entrega un objeto Range: se toma su valor (una sola celda)
    If IsObject(v) Then
        If TypeName(v) <> "Range" Then Exit Function
        If v.Cells.Count <> 1 Then Exit Function
        v = v.Value
    End If
    If IsError(v) Or IsEmpty(v) Or IsArray(v) Then Exit Function
    If VarType(v) = vbBoolean Then Exit Function

    If VarType(v) = vbString Then
        If Not LeerTexto(CStr(v), lang, signo, intDigits, fracDigits) Then Exit Function
    ElseIf IsNumeric(v) Then
        Dim d As Variant, k As Integer, dg As Variant
        d = CDec(v)
        If d < 0 Then signo = "-": d = -d
        intDigits = Format(Fix(d), "0")
        d = d - Fix(d)
        For k = 1 To digitos + 1
            d = d * 10
            dg = Fix(d)
            fracDigits = fracDigits & CStr(CInt(dg))
            d = d - dg
        Next
    Else
        Exit Function
    End If

    ' Sin ceros a la izquierda; maximo 15 cifras enteras
    Do While Len(intDigits) > 1 And Left(intDigits, 1) = "0"
        intDigits = Mid(intDigits, 2)
    Loop
    If Len(intDigits) > 15 Then Exit Function
    entero = CDec(intDigits)

    ' Redondeo "mitad hacia arriba" a la cantidad de decimales pedida
    fracDigits = Left(fracDigits & String(digitos + 1, "0"), digitos + 1)
    fraccion = CDec(0)
    If digitos > 0 Then fraccion = CDec(Left(fracDigits, digitos))
    If Mid(fracDigits, digitos + 1, 1) >= "5" Then
        fraccion = fraccion + 1
        If fraccion >= CDec(10) ^ digitos Then
            fraccion = CDec(0)
            entero = entero + 1
        End If
    End If
    If entero > CDec("999999999999999") Then Exit Function
    negativo = (signo = "-") And (entero > 0 Or fraccion > 0)
    Normalizar = True
End Function

' Texto: en espanol "1.250.000,50" (coma decimal) o "1250000.5"; en ingles "1,250,000.50".
Private Function LeerTexto(ByVal s As String, ByVal lang As String, signo As String, _
                           intDigits As String, fracDigits As String) As Boolean
    s = Trim(Replace(Replace(s, vbTab, ""), Chr(160), ""))
    If s = "" Then Exit Function
    If Left(s, 1) = "+" Or Left(s, 1) = "-" Then signo = Left(s, 1): s = Mid(s, 2)
    If s = "" Then Exit Function

    Dim cuerpo As String, parteDecimal As String, milesSep As String, pos As Long
    If lang = "en" Then
        milesSep = ","
        pos = InStr(s, ".")
        If InStr(pos + 1, s, ".") > 0 And pos > 0 Then Exit Function
    ElseIf InStr(s, ",") > 0 Then
        milesSep = "."
        pos = InStr(s, ",")
        If InStr(pos + 1, s, ",") > 0 Then Exit Function
    ElseIf Len(s) - Len(Replace(s, ".", "")) > 1 Then
        milesSep = "."
        pos = 0
    Else
        milesSep = ""
        pos = InStr(s, ".")
    End If

    If pos > 0 Then
        cuerpo = Left(s, pos - 1)
        parteDecimal = Mid(s, pos + 1)
        If parteDecimal = "" Or Not SoloDigitos(parteDecimal) Then Exit Function
    Else
        cuerpo = s
    End If
    If cuerpo = "" Then Exit Function

    If milesSep <> "" And InStr(cuerpo, milesSep) > 0 Then
        Dim grupos As Variant, i As Long
        grupos = Split(cuerpo, milesSep)
        If Len(grupos(0)) < 1 Or Len(grupos(0)) > 3 Or Not SoloDigitos(CStr(grupos(0))) Then Exit Function
        For i = 1 To UBound(grupos)
            If Len(grupos(i)) <> 3 Or Not SoloDigitos(CStr(grupos(i))) Then Exit Function
        Next
        cuerpo = Replace(cuerpo, milesSep, "")
    End If
    If Not SoloDigitos(cuerpo) Then Exit Function
    intDigits = cuerpo
    fracDigits = parteDecimal
    LeerTexto = True
End Function

Private Function SoloDigitos(ByVal s As String) As Boolean
    Dim i As Long
    If s = "" Then Exit Function
    For i = 1 To Len(s)
        If Mid(s, i, 1) < "0" Or Mid(s, i, 1) > "9" Then Exit Function
    Next
    SoloDigitos = True
End Function

' Residuo y division entera con Decimal (Mod de VBA desborda con numeros grandes)
Private Function Residuo(ByVal a As Variant, ByVal b As Variant) As Variant
    Residuo = a - Fix(a / b) * b
End Function

'------------------------------------------------------------------------------
' Espanol
'------------------------------------------------------------------------------
Private Function EsEntero(ByVal n As Variant, ByVal apocope As Boolean) As String
    If n = 0 Then EsEntero = "cero": Exit Function
    Dim billones As Long, millones As Long, resto As Long, partes As String
    billones = CLng(Fix(n / CDec("1000000000000")))
    millones = CLng(Fix(Residuo(n, CDec("1000000000000")) / CDec(1000000)))
    resto = CLng(Residuo(n, CDec(1000000)))
    If billones = 1 Then
        partes = Tx("un bill~on")
    ElseIf billones > 1 Then
        partes = EsBajoMillon(billones, True) & " billones"
    End If
    If millones = 1 Then
        partes = Unir(partes, Tx("un mill~on"))
    ElseIf millones > 1 Then
        partes = Unir(partes, EsBajoMillon(millones, True) & " millones")
    End If
    If resto > 0 Then partes = Unir(partes, EsBajoMillon(resto, apocope))
    EsEntero = partes
End Function

Private Function EsBajoMillon(ByVal n As Long, ByVal apocope As Boolean) As String
    Dim miles As Long, resto As Long, partes As String
    miles = n \ 1000
    resto = n Mod 1000
    If miles = 1 Then
        partes = "mil"
    ElseIf miles > 1 Then
        partes = EsBajoMil(miles, True) & " mil"
    End If
    If resto > 0 Then partes = Unir(partes, EsBajoMil(resto, apocope))
    EsBajoMillon = partes
End Function

Private Function EsBajoMil(ByVal n As Long, ByVal apocope As Boolean) As String
    Dim centenas As Long, resto As Long, partes As String, palabra As String, unidad As Long
    centenas = n \ 100
    resto = n Mod 100
    If centenas > 0 Then partes = IIf(n = 100, "cien", esHundreds(centenas))
    If resto > 0 Then
        If resto < 30 Then
            palabra = esUnits(resto)
            If apocope And resto = 1 Then
                palabra = "un"
            ElseIf apocope And resto = 21 Then
                palabra = Tx("veinti~un")
            End If
        Else
            unidad = resto Mod 10
            palabra = esTens(resto \ 10)
            If unidad > 0 Then palabra = palabra & " y " & IIf(apocope And unidad = 1, "un", esUnits(unidad))
        End If
        partes = Unir(partes, palabra)
    End If
    EsBajoMil = partes
End Function

Private Function Unir(ByVal a As String, ByVal b As String) As String
    If a = "" Then Unir = b Else Unir = a & " " & b
End Function

'------------------------------------------------------------------------------
' English
'------------------------------------------------------------------------------
Private Function EnEntero(ByVal n As Variant) As String
    If n = 0 Then EnEntero = "zero": Exit Function
    Dim escalas As Variant, nombres As Variant, i As Integer, parte As Variant, s As String
    escalas = Array(CDec("1000000000000"), CDec("1000000000"), CDec("1000000"), CDec("1000"))
    nombres = Array("trillion", "billion", "million", "thousand")
    For i = 0 To 3
        If n >= escalas(i) Then
            parte = Fix(n / escalas(i))
            s = Unir(s, EnBajoMil(CLng(parte)) & " " & nombres(i))
            n = n - parte * escalas(i)
        End If
    Next
    If n > 0 Then s = Unir(s, EnBajoMil(CLng(n)))
    EnEntero = s
End Function

Private Function EnBajoMil(ByVal n As Long) As String
    Dim s As String
    If n >= 100 Then
        s = enOnes(n \ 100) & " hundred"
        n = n Mod 100
    End If
    If n >= 20 Then
        s = Unir(s, enTens(n \ 10) & IIf(n Mod 10 > 0, "-" & enOnes(n Mod 10), ""))
    ElseIf n > 0 Then
        s = Unir(s, enOnes(n))
    End If
    EnBajoMil = s
End Function
