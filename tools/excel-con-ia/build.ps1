# Construye y prueba el kit gratuito «Excel con IA» y lo publica en public/descargas/excel-con-ia/.
#   pwsh -File tools/excel-con-ia/build.ps1            pruebas sin llamadas reales a Gemini
#   pwsh -File tools/excel-con-ia/build.ps1 -ConIA     además ~8 llamadas reales (clave GEMINI_API_KEY del .env)
# Requiere Excel para Windows y Python con pandas, numpy y openpyxl (y requests para -ConIA).
# Como tools/excel/build.ps1: activa temporalmente AccessVBOM (importar el .bas por COM) y lo deja como
# estaba; el trabajo con Excel corre en un proceso hijo para que Excel se cierre del todo.
param([switch]$Worker, [switch]$ConIA)
$ErrorActionPreference = 'Stop'
$root = Resolve-Path "$PSScriptRoot\..\.."
$work = Join-Path $env:TEMP 'eo-excel-con-ia'
$pkg = Join-Path $work 'paquete'
$out = "$root\public\descargas\excel-con-ia"

function Get-EnvKey {
  $line = Get-Content "$root\.env" -Encoding UTF8 | Where-Object { $_ -match '^\s*GEMINI_API_KEY\s*=' } | Select-Object -First 1
  if (-not $line) { return '' }
  return ($line -replace '^\s*GEMINI_API_KEY\s*=\s*', '').Trim().Trim('"').Trim("'")
}

if (-not $Worker) {
  # ======================= Proceso principal =======================
  if (Test-Path $work) { Remove-Item $work -Recurse -Force }
  New-Item -ItemType Directory -Force $pkg, $out | Out-Null

  # 1. Datos de ejemplo
  & python "$PSScriptRoot\generar_datos.py" $pkg
  if ($LASTEXITCODE -ne 0) { throw 'generar_datos.py falló' }

  # 2. Módulo VBA en Windows-1252 con CRLF (así el editor de VBA importa bien las tildes).
  #    La codificación es estricta: un carácter fuera de Windows-1252 detiene la construcción.
  $ansi = [Text.Encoding]::GetEncoding(1252, [Text.EncoderFallback]::ExceptionFallback, [Text.DecoderFallback]::ExceptionFallback)
  $bas = [IO.File]::ReadAllText("$PSScriptRoot\ExcelConIA.bas", [Text.Encoding]::UTF8) -replace "`r?`n", "`r`n"
  [IO.File]::WriteAllBytes("$pkg\ExcelConIA.bas", $ansi.GetBytes($bas))
  $maxLen = ($bas -split "`r`n" | Measure-Object -Property Length -Maximum).Maximum
  if ($maxLen -gt 1023) { throw "Hay una línea de $maxLen caracteres en el .bas (VBA admite 1023)" }

  # 3. Archivos de Python y LEEME (UTF-8 con BOM y CRLF para el Bloc de notas)
  Copy-Item "$PSScriptRoot\analisis_con_python.py", "$PSScriptRoot\requirements.txt" $pkg
  $leeme = [IO.File]::ReadAllText("$PSScriptRoot\LEEME.txt", [Text.Encoding]::UTF8) -replace "`r?`n", "`r`n"
  [IO.File]::WriteAllText("$pkg\LEEME.txt", $leeme, (New-Object Text.UTF8Encoding $true))

  # 4. Script de Python de punta a punta: sin clave y (con -ConIA) con clave
  $key = Get-EnvKey
  $env:GEMINI_API_KEY = $null
  New-Item -ItemType Directory -Force "$work\py-sin-clave", "$work\py-con-clave" | Out-Null
  & python "$pkg\analisis_con_python.py" --datos "$pkg\datos-ejemplo.xlsx" --salida "$work\py-sin-clave\reporte.xlsx"
  if ($LASTEXITCODE -ne 0) { throw 'analisis_con_python.py falló sin clave' }
  if ($ConIA) {
    if (-not $key) { throw 'No hay GEMINI_API_KEY en .env' }
    $env:GEMINI_API_KEY = $key
    try {
      & python "$pkg\analisis_con_python.py" --datos "$pkg\datos-ejemplo.xlsx" --salida "$work\py-con-clave\reporte.xlsx"
      if ($LASTEXITCODE -ne 0) { throw 'analisis_con_python.py falló con clave' }
      # Segunda ejecución: todo sale de la caché, sin llamadas nuevas
      & python "$pkg\analisis_con_python.py" --datos "$pkg\datos-ejemplo.xlsx" --salida "$work\py-con-clave\reporte.xlsx" | Select-String 'caché|Clasificación|Listo'
    } finally { $env:GEMINI_API_KEY = $null }
  }

  # 5. Pruebas con Excel (proceso hijo)
  $reg = 'HKCU:\Software\Microsoft\Office\16.0\Excel\Security'
  if (-not (Test-Path $reg)) { New-Item $reg -Force | Out-Null }
  $orig = (Get-ItemProperty $reg -Name AccessVBOM -ErrorAction SilentlyContinue).AccessVBOM
  "AccessVBOM original: [$orig]"
  $before = @(Get-Process EXCEL -ErrorAction SilentlyContinue | ForEach-Object Id)
  Set-ItemProperty $reg -Name AccessVBOM -Value 1 -Type DWord
  try {
    if ($ConIA) { $env:EO_CLAVE_PRUEBA = $key }
    & pwsh -NoProfile -File $PSCommandPath -Worker -ConIA:$ConIA
    $workerOk = $LASTEXITCODE -eq 0
  } finally {
    $env:EO_CLAVE_PRUEBA = $null
    $mine = @(Get-Process EXCEL -ErrorAction SilentlyContinue | Where-Object { $before -notcontains $_.Id })
    foreach ($p in $mine) { if (-not $p.WaitForExit(120000)) { $p.Kill() } }
    for ($i = 0; $i -lt 4; $i++) {
      Start-Sleep -Seconds 3
      if ($null -eq $orig) { Remove-ItemProperty $reg -Name AccessVBOM -ErrorAction SilentlyContinue } else { Set-ItemProperty $reg -Name AccessVBOM -Value $orig -Type DWord }
    }
    "AccessVBOM restaurado: [" + (Get-ItemProperty $reg -Name AccessVBOM -ErrorAction SilentlyContinue).AccessVBOM + "]"
  }
  if (-not $workerOk) { throw 'Las pruebas con Excel fallaron: no se actualizaron las descargas.' }

  # 6. El perfil de Excel debe coincidir con pandas
  & python "$PSScriptRoot\verificar_perfil.py" "$pkg\datos-ejemplo.xlsx" "$work\perfil_excel.json"
  if ($LASTEXITCODE -ne 0) { throw 'El perfil de Excel no coincide con pandas.' }

  # 7. Publicación
  $zip = "$out\excel-con-ia.zip"
  if (Test-Path $zip) { Remove-Item $zip -Force }
  $files = 'ExcelConIA.bas', 'datos-ejemplo.xlsx', 'analisis_con_python.py', 'requirements.txt', 'LEEME.txt' | ForEach-Object { "$pkg\$_" }
  Compress-Archive -Path $files -DestinationPath $zip -CompressionLevel Optimal
  # El módulo solo también va comprimido: algunos navegadores y antivirus bloquean o muestran un .bas suelto.
  $mod = "$out\ExcelConIA-modulo.zip"
  if (Test-Path $mod) { Remove-Item $mod -Force }
  Compress-Archive -Path "$pkg\ExcelConIA.bas" -DestinationPath $mod -CompressionLevel Optimal
  foreach ($f in (Get-ChildItem $out)) { "{0,-22} {1,9:N0} bytes" -f $f.Name, $f.Length }
  exit 0
}

# ======================= Proceso hijo: pruebas con Excel =======================
$fallas = [Collections.Generic.List[string]]::new()
function Check([bool]$ok, [string]$what) {
  if ($ok) { "  OK    $what" } else { "  FALLA $what"; $script:fallas.Add($what) }
}
function Cell($ws, [string]$addr) { $ws.Range($addr).Value2 }
function Read-Profile($wb) {
  $p = $wb.Worksheets.Item('Perfil de datos')
  $lo = $p.ListObjects.Item(1)
  $v = $lo.DataBodyRange.Value2
  $h = $lo.HeaderRowRange.Value2
  $rows = for ($r = 1; $r -le $lo.ListRows.Count; $r++) {
    $o = [ordered]@{}
    for ($c = 1; $c -le 12; $c++) { $o[[string]$h[1, $c]] = $v[$r, $c] }
    [pscustomobject]$o
  }
  $end = $lo.Range.Row + $lo.Range.Rows.Count - 1
  $last = $p.UsedRange.Row + $p.UsedRange.Rows.Count - 1
  $lines = for ($r = $end + 6; $r -le $last; $r++) { [string]$p.Cells.Item($r, 1).Value2 }
  [pscustomobject]@{
    filas = [int](([string](Cell $p 'B6')) -replace '\.', '')
    columnas = [int](Cell $p 'B7')
    duplicadas = [int](([string](Cell $p 'B8')) -replace '\s.*$', '' -replace '\.', '')
    perfil = @($rows)
    prompt = ($lines -join "`r`n")
    titulo = [string]$p.Cells.Item($end + 3, 1).Value2
    nota = [string]$p.Cells.Item($end + 4, 1).Value2
    tiempo = [string](Cell $p 'B10')
  }
}

$xl = New-Object -ComObject Excel.Application
try {
  $xl.AutomationSecurity = 1; $xl.Visible = $false; $xl.DisplayAlerts = $false
  Copy-Item "$pkg\datos-ejemplo.xlsx" "$work\prueba.xlsx"
  $wb = $xl.Workbooks.Open("$work\prueba.xlsx")

  "Importación del módulo"
  $comp = $wb.VBProject.VBComponents.Import("$pkg\ExcelConIA.bas")
  $code = $comp.CodeModule.Lines(1, $comp.CodeModule.CountOfLines)
  Check ($comp.Name -eq 'ExcelConIA') "nombre del módulo: $($comp.Name)"
  Check ($code.Contains('Versión 1.0') -and $code.Contains('"Número"') -and $code.Contains('¿Qué quieres lograr') -and $code.Contains('«')) 'tildes, ñ, ¿ y « importadas correctamente'
  Check (-not $code.Contains('Attribute VB_')) 'atributos consumidos por el importador'

  "PerfilarDatos en cada hoja"
  $export = [ordered]@{}
  foreach ($hoja in 'Ventas', 'Notas', 'Encuesta') {
    $ws = $wb.Worksheets.Item($hoja)
    $ws.Activate(); $ws.Range('C5').Select() | Out-Null
    $sw = [Diagnostics.Stopwatch]::StartNew()
    $xl.Run('PerfilarDatosConObjetivo', "Prueba automática de la hoja $hoja") | Out-Null
    $ms = $sw.ElapsedMilliseconds
    $r = Read-Profile $wb
    $export[$hoja] = [ordered]@{ filas = $r.filas; columnas = $r.columnas; duplicadas = $r.duplicadas; perfil = $r.perfil }
    [IO.File]::WriteAllText("$work\prompt-$hoja.txt", $r.prompt, [Text.Encoding]::UTF8)
    Check ($r.filas -gt 0 -and $r.perfil.Count -eq $r.columnas) "$hoja`: $($r.filas) filas, $($r.columnas) columnas, $($r.duplicadas) duplicadas, $ms ms ($($r.tiempo))"
    Check ($r.prompt.Contains("Prueba automática de la hoja $hoja") -and $r.prompt.Contains('LO QUE NECESITO') -and $r.prompt.Contains('pandas')) "$hoja`: prompt con objetivo y secciones ($($r.prompt.Length) caracteres)"
    $clip = (Get-Clipboard -Raw)
    Check ($null -ne $clip -and $clip.TrimEnd() -eq $r.prompt.TrimEnd()) "$hoja`: prompt copiado al portapapeles idéntico ($($r.nota.Substring(0, 24))…)"
    $raw = $ws.UsedRange.Value2
    $leak = $false
    # Ninguna fila completa debe aparecer: se buscan valores largos de texto que no sean el más frecuente
    foreach ($i in 2..[Math]::Min(60, $raw.GetLength(0))) {
      $s = [string]$raw[$i, 4]
      if ($s.Length -gt 12 -and $r.prompt.Contains($s) -and -not ($r.perfil | Where-Object { [string]$_.'Más frecuente' -like "$s*" })) { $leak = $true }
    }
    Check (-not $leak) "$hoja`: el prompt no contiene filas"
  }
  ($export | ConvertTo-Json -Depth 6) | Set-Content "$work\perfil_excel.json" -Encoding UTF8

  $v = (Read-Profile $wb)
  "Prompt de ejemplo (Encuesta), primeras líneas:"
  ($v.prompt -split "`r`n" | Select-Object -First 16) | ForEach-Object { "    | $_" }

  "GenerarPromptIA sola (objetivo por defecto, reemplaza el prompt anterior)"
  $wb.Worksheets.Item('Encuesta').Activate()
  $xl.Run('GenerarPromptIA') | Out-Null
  $v2 = Read-Profile $wb
  Check ($v2.prompt.Contains('Entender estos datos, detectar problemas') -and -not $v2.prompt.Contains('Prueba automática')) 'objetivo por defecto y prompt reemplazado'
  Check (($v2.prompt -split "`r`n").Count -eq ($v.prompt -split "`r`n").Count) 'mismo número de líneas, sin restos del prompt anterior'
  $wb.Worksheets.Item('Perfil de datos').Activate()
  $xl.Run('PerfilarDatos') | Out-Null
  Check $true 'PerfilarDatos desde la hoja de resultados no falla (solo avisa)'

  "Casos borde: tabla de Excel con fila de totales, error, encabezado vacío, columna vacía y lógicos"
  $wsB = $wb.Worksheets.Add(); $wsB.Name = 'Bordes'
  $wsB.Range('A1:E1').Value2 = [object[]]@('Código', 'Activo', $null, 'Vacía', 'Valor')
  $wsB.Range('C1').Value2 = ''
  for ($i = 2; $i -le 13; $i++) {
    $wsB.Cells.Item($i, 1).Value2 = "C-$i"
    $wsB.Cells.Item($i, 2).Value2 = ($i % 2 -eq 0)
    $wsB.Cells.Item($i, 3).Value2 = "x"
    $wsB.Cells.Item($i, 5).Formula = "=$i*10"
  }
  $wsB.Range('E7').Formula = '=NA()'
  $wsB.Range('A1').Value2 = 'Código'
  $loB = $wsB.ListObjects.Add(1, $wsB.Range('A1:E13'), [Type]::Missing, 1)
  $loB.ShowTotals = $true
  $wsB.Range('B4').Select() | Out-Null
  $xl.Run('PerfilarDatosConObjetivo', 'bordes') | Out-Null
  $b = Read-Profile $wb
  $al = ($b.perfil | ForEach-Object { "$($_.Columna)=$($_.'Tipo inferido')[$($_.Alertas)]" }) -join ' / '
  "    $al"
  Check ($b.filas -eq 12) "ListObject sin la fila de totales: $($b.filas) filas"
  Check ($al -match 'Valor=Mixto\[.*celdas con error: 1' -or $al -match 'Valor=Número\[.*celdas con error: 1') 'error #N/A contado'
  Check ($al -match 'Vacía=Vacía\[columna vacía') 'columna vacía detectada'
  Check ($al -match 'posible ID') 'posible ID en Código'
  Check ($al -match 'Activo=Texto\[') 'valores lógicos tratados como texto'
  $hdr = ($b.perfil | Where-Object { $_.Columna -like 'Columna*' })
  Check ($null -ne $hdr -or $al -match 'sin encabezado') "encabezado vacío nombrado ($(@($hdr)[0].Columna))"

  "Rendimiento: 20.000 filas"
  $src = $wb.Worksheets.Item('Ventas')
  $wsG = $wb.Worksheets.Add(); $wsG.Name = 'Grande'
  $src.Range('A1:J1').Copy($wsG.Range('A1')) | Out-Null
  $n = $src.UsedRange.Rows.Count - 1
  for ($k = 0; $k -lt 25; $k++) { $src.Range("A2:J$($n + 1)").Copy($wsG.Range("A$(2 + $k * $n)")) | Out-Null }
  $wsG.Range('A2').Select() | Out-Null
  $sw = [Diagnostics.Stopwatch]::StartNew()
  $xl.Run('PerfilarDatosConObjetivo', 'rendimiento') | Out-Null
  $ms = $sw.ElapsedMilliseconds
  $g = Read-Profile $wb
  Check ($g.filas -eq 25 * $n -and $g.duplicadas -eq 25 * $n - ($n - 10)) "$($g.filas) filas perfiladas en $ms ms (macro: $($g.tiempo)); duplicadas $($g.duplicadas)"

  "Funciones IA"
  $wsI = $wb.Worksheets.Add(); $wsI.Name = 'Pruebas IA'
  $ciudades = 'Cali', 'Medellín', 'Cali', 'Bogotá', 'Cali'
  for ($i = 0; $i -lt 5; $i++) { $wsI.Cells.Item(2 + $i, 2).Formula = [string]$ciudades[$i] }
  foreach ($nm in @($wb.Names)) { if ($nm.Name -like '*IA_CLAVE_GEMINI') { $nm.Delete() } }
  $wsI.Range('A1').Formula = '=IA("Di hola")'
  $xl.Calculate()
  $sinClave = [string]$wsI.Range('A1').Value2
  Check ($sinClave.StartsWith('#IA: falta la clave')) "sin clave: $sinClave"
  $wsI.Range('A2').Formula = '=IA_CLASIFICAR("","a,b")'
  $wsI.Range('A3').Formula = '=IA_CLASIFICAR("hola","solo una")'
  $xl.Calculate()
  Check ([string]$wsI.Range('A2').Value2 -eq '' -and ([string]$wsI.Range('A3').Value2).StartsWith('#IA: indica al menos dos')) 'texto vacío sin consulta y validación de categorías'

  [void]$wb.Names.Add('IA_CLAVE_GEMINI', '="AIzaSyPRUEBAinvalidaPRUEBAinvalida0000000"', $false)
  $wsI.Range('A4').Formula = '=IA("Di hola, prueba de clave inválida")'
  $xl.Calculate()
  $inval = [string]$wsI.Range('A4').Value2
  Check ($inval.StartsWith('#IA: la clave de Gemini no es válida')) "clave inválida (1 llamada rechazada): $inval"

  if ($ConIA) {
    $wb.Names.Item('IA_CLAVE_GEMINI').Delete()
    [void]$wb.Names.Add('IA_CLAVE_GEMINI', "=""$($env:EO_CLAVE_PRUEBA)""", $false)
    $pruebas = [ordered]@{
      'C1' = '=IA("Responde solo con el nombre de la capital de Colombia, sin punto final.")'
      'C2' = '=IA("¿Qué ciudad aparece más veces? Responde solo el nombre.",B2:B6)'
      'C3' = '=IA_CLASIFICAR(Encuesta!G2,Encuesta!$K$2:$K$6)'
      'C4' = '=IA_CLASIFICAR("Llegó rápido y bien empacado, excelente servicio","Positivo, Negativo, Neutro")'
      'C5' = '=IA_EXTRAER("Escríbeme a ana.perez@ejemplo.com, soy de Cali","correo")'
      'C6' = '=IA_EXTRAER("Pagué $1.250.000 el 3 de marzo de 2026 en Medellín","monto")'
      'C7' = '=IA_EXTRAER("Pagué $1.250.000 el 3 de marzo de 2026 en Medellín","teléfono")'
    }
    $sw = [Diagnostics.Stopwatch]::StartNew()
    foreach ($k in $pruebas.Keys) { $wsI.Range($k).Formula = $pruebas[$k] }
    $xl.Calculate()
    $msIA = $sw.ElapsedMilliseconds
    $res = @{}
    foreach ($k in $pruebas.Keys) { $res[$k] = $wsI.Range($k).Value2; "    $k $($pruebas[$k])`n       -> [$($res[$k])] ($($res[$k].GetType().Name))" }
    $cats = @($wb.Worksheets.Item('Encuesta').Range('K2:K6').Value2 | ForEach-Object { [string]$_ })
    "    G2 de Encuesta: " + $wb.Worksheets.Item('Encuesta').Range('G2').Value2
    Check ([string]$res['C1'] -like 'Bogot*') "IA simple con tildes: $($res['C1'])"
    Check ([string]$res['C2'] -like '*Cali*') 'IA con rango de contexto'
    Check ($cats -contains [string]$res['C3']) "IA_CLASIFICAR con rango: $($res['C3'])"
    Check ([string]$res['C4'] -eq 'Positivo') 'IA_CLASIFICAR con texto de categorías'
    Check ([string]$res['C5'] -eq 'ana.perez@ejemplo.com') 'IA_EXTRAER correo'
    Check ($res['C6'] -is [double] -and $res['C6'] -eq 1250000) 'IA_EXTRAER monto devuelve número'
    Check ([string]$res['C7'] -eq '') 'IA_EXTRAER dato ausente devuelve vacío'
    "    7 llamadas en $msIA ms"
    $sw = [Diagnostics.Stopwatch]::StartNew()
    $xl.CalculateFull()
    $msCache = $sw.ElapsedMilliseconds
    $same = ($pruebas.Keys | Where-Object { [string]$wsI.Range($_).Value2 -ne [string]$res[$_] }).Count -eq 0
    Check ($same -and $msCache -lt 3000) "recálculo completo desde la caché: $msCache ms"
    $xl.Run('LimpiarCacheIA') | Out-Null
    Check $true 'LimpiarCacheIA'
  }
  $xl.Run('ConfigurarIA') | Out-Null   # oculto: no muestra nada y no cambia la clave
  Check ($null -ne $wb.Names.Item('IA_CLAVE_GEMINI')) 'ConfigurarIA sin interfaz no altera la clave'

  # Sin clave antes de guardar la copia de inspección
  foreach ($nm in @($wb.Names)) { if ($nm.Name -like '*IA_CLAVE_GEMINI') { $nm.Delete() } }
  $wb.Worksheets.Item('Ventas').Activate(); $wb.Worksheets.Item('Ventas').Range('A2').Select() | Out-Null
  $xl.Run('PerfilarDatosConObjetivo', 'Saber qué ciudades y productos crecen más y qué datos debo corregir') | Out-Null
  $wb.SaveAs("$work\prueba-revisada.xlsm", 52)
  $wb.Close($false)

  "Reportes de Python abiertos en Excel"
  foreach ($d in 'py-sin-clave', 'py-con-clave') {
    $f = "$work\$d\reporte.xlsx"
    if (-not (Test-Path $f)) { continue }
    $r = $xl.Workbooks.Open($f)
    $charts = 0; foreach ($s in @($r.Worksheets)) { $charts += $s.ChartObjects().Count }
    $ia = $r.Worksheets.Item('Comentarios IA')
    $clasif = 0; $last = $ia.UsedRange.Rows.Count
    for ($i = 2; $i -le $last; $i++) { if ([string]$ia.Cells.Item($i, 3).Value2) { $clasif++ } }
    Check ($r.Worksheets.Count -eq 15 -and $charts -eq 3) "$d`: $($r.Worksheets.Count) hojas, $charts gráficos, $clasif de $($last - 1) comentarios con categoría"
    "      Resumen: " + (@(2..15 | ForEach-Object { "$($r.Worksheets.Item('Resumen').Cells.Item($_, 1).Text) = $($r.Worksheets.Item('Resumen').Cells.Item($_, 2).Text)" }) -join ' | ')
    $r.Close($false)
  }
} finally {
  $xl.Quit()
  [void][Runtime.InteropServices.Marshal]::ReleaseComObject($xl)
}
if ($fallas.Count -gt 0) { "FALLAS: $($fallas.Count)"; exit 1 }
'Todas las pruebas con Excel pasaron.'
exit 0
