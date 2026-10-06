# Construye las descargas gratuitas para Excel (módulos .bas, complementos .xlam y libros de ejemplo .xlsm)
# y las empaqueta en public/descargas/. Requiere Excel para Windows y Node (para los casos de QR).
#   pwsh -File tools/excel/build.ps1
# Activa temporalmente "Confiar en el acceso al modelo de objetos de proyectos de VBA" (AccessVBOM) y lo deja
# como estaba. El trabajo con Excel corre en un proceso hijo: Excel solo se cierra del todo (y reescribe ese
# valor) cuando se liberan todas las referencias COM, es decir, cuando termina el proceso que lo controla.
param([switch]$Worker)
$ErrorActionPreference = 'Stop'
$root = Resolve-Path "$PSScriptRoot\..\.."
$work = Join-Path $env:TEMP "eo-excel-build"
$out = "$root\public\descargas"
$books = @(
  @{ zip = 'numero-a-letras-excel'; lang = 'es'; mod = 'NumerosALetras'; example = 'NumerosALetras-ejemplo.xlsm'; readme = 'numero-a-letras.es.txt'; title = 'Número a letras para Excel (edwinortiz.net)' },
  @{ zip = 'number-to-words-excel'; lang = 'en'; mod = 'NumerosALetras'; example = 'NumerosALetras-example.xlsm'; readme = 'numero-a-letras.en.txt'; title = 'Number to words for Excel (edwinortiz.net)' },
  @{ zip = 'codigo-qr-excel'; lang = 'es'; mod = 'CodigoQR'; example = 'CodigoQR-ejemplo.xlsm'; readme = 'codigo-qr.es.txt'; title = 'Códigos QR para Excel (edwinortiz.net)' },
  @{ zip = 'qr-code-excel'; lang = 'en'; mod = 'CodigoQR'; example = 'CodigoQR-example.xlsm'; readme = 'codigo-qr.en.txt'; title = 'QR codes for Excel (edwinortiz.net)' }
)

if (-not $Worker) {
  # ---------------- Proceso principal ----------------
  Remove-Item $work -Recurse -Force -ErrorAction SilentlyContinue
  New-Item -ItemType Directory -Force $work, $out | Out-Null
  # Módulos con CRLF y ASCII (así los importa VBA en cualquier configuración regional)
  foreach ($m in 'NumerosALetras', 'CodigoQR') {
    $txt = [IO.File]::ReadAllText("$PSScriptRoot\src\$m.bas") -replace "`r?`n", "`r`n"
    [IO.File]::WriteAllText("$work\$m.bas", $txt, [Text.Encoding]::ASCII)
  }
  # Casos de referencia del QR generados con el codificador del sitio
  & node "$PSScriptRoot\qrcases.mjs" "$work\qrcases.json" | Out-Null

  $key = 'HKCU:\Software\Microsoft\Office\16.0\Excel\Security'
  if (-not (Test-Path $key)) { New-Item $key -Force | Out-Null }
  $orig = (Get-ItemProperty $key -Name AccessVBOM -ErrorAction SilentlyContinue).AccessVBOM
  $before = @(Get-Process EXCEL -ErrorAction SilentlyContinue | ForEach-Object Id)
  Set-ItemProperty $key -Name AccessVBOM -Value 1 -Type DWord
  try {
    & pwsh -NoProfile -File $PSCommandPath -Worker
    $workerOk = $LASTEXITCODE -eq 0
  } finally {
    # Espera a que el Excel de este proceso termine; luego restaura el valor original
    $mine = @(Get-Process EXCEL -ErrorAction SilentlyContinue | Where-Object { $before -notcontains $_.Id })
    foreach ($p in $mine) { $p.WaitForExit(120000) | Out-Null }
    for ($i = 0; $i -lt 4; $i++) {
      Start-Sleep -Seconds 3
      if ($null -eq $orig) { Remove-ItemProperty $key -Name AccessVBOM -ErrorAction SilentlyContinue } else { Set-ItemProperty $key -Name AccessVBOM -Value $orig -Type DWord }
    }
    "AccessVBOM restaurado: [" + (Get-ItemProperty $key -Name AccessVBOM -ErrorAction SilentlyContinue).AccessVBOM + "]"
  }
  if (-not $workerOk) { throw 'La construcción falló: no se actualizaron las descargas.' }

  foreach ($b in $books) {
    $zip = "$out\$($b.zip).zip"
    Remove-Item $zip -ErrorAction SilentlyContinue
    Compress-Archive -Path "$work\$($b.zip)\*" -DestinationPath $zip -CompressionLevel Optimal
    "{0,-28} {1,8:N0} bytes" -f "$($b.zip).zip", (Get-Item $zip).Length
  }
  exit 0
}

# ---------------- Proceso hijo: pruebas y archivos con Excel ----------------
function New-Book($xl, [string[]]$modules) {
  $wb = $xl.Workbooks.Add()
  foreach ($m in $modules) { [void]$wb.VBProject.VBComponents.Import("$work\$m.bas") }
  while ($wb.Worksheets.Count -gt 1) { $wb.Worksheets.Item($wb.Worksheets.Count).Delete() }
  return $wb
}
function Set-DocProp($wb, [string]$name, [string]$value) {
  # Las propiedades de documento de Office solo se alcanzan por reflexión desde PowerShell
  $props = $wb.BuiltinDocumentProperties
  $p = [System.__ComObject].InvokeMember('Item', [Reflection.BindingFlags]::GetProperty, $null, $props, @($name))
  [void][System.__ComObject].InvokeMember('Value', [Reflection.BindingFlags]::SetProperty, $null, $p, @($value))
}
function Set-Header($ws, [string]$title, [string]$subtitle, [string[]]$cols) {
  $ws.Range('A1').Value2 = $title
  $ws.Range('A1').Font.Size = 16; $ws.Range('A1').Font.Bold = $true; $ws.Range('A1').Font.Color = 0x00F05023
  $ws.Range('A2').Value2 = $subtitle
  $ws.Range('A2').Font.Color = 0x00796053
  for ($i = 0; $i -lt $cols.Count; $i++) {
    $c = $ws.Cells.Item(4, $i + 1)
    $c.Value2 = $(if ($cols[$i].StartsWith('=')) { "'" + $cols[$i] } else { $cols[$i] })
    $c.Font.Bold = $true; $c.Font.Color = 0xFFFFFF; $c.Interior.Color = 0x00F05023
  }
}

$xl = New-Object -ComObject Excel.Application
try {
  $xl.AutomationSecurity = 1; $xl.Visible = $false; $xl.DisplayAlerts = $false; $xl.Interactive = $false

  # ---------- Pruebas ----------
  $wb = New-Book $xl @('NumerosALetras', 'CodigoQR')
  $cases = Get-Content "$root\tests\fixtures\numwords_cases.json" -Raw -Encoding UTF8 | ConvertFrom-Json
  $bad = 0
  foreach ($c in $cases) {
    $fn = if ($c.lang -eq 'es') { 'NUMEROALETRAS' } else { 'NUMBERTOWORDS' }
    $dec = if ($null -ne $c.PSObject.Properties['decimals']) { [int]$c.decimals } else { 2 }
    $r = $xl.Run($fn, $c.input, [bool]$c.currency, $dec)
    $isErr = $r -is [int] -and $r -lt -2146826000
    if (-not (($null -eq $c.expected -and $isErr) -or (-not $isErr -and $r -ceq $c.expected))) { $bad++; "  FALLA: $($c.input) -> $r" }
  }
  "Número a letras: $($cases.Count - $bad)/$($cases.Count) casos correctos"
  $q = Get-Content "$work\qrcases.json" -Raw -Encoding UTF8 | ConvertFrom-Json
  $qbad = @($q | Where-Object { $xl.Run('QR_MATRIZ', $_.text, $_.ecc) -cne $_.matrix }).Count
  "QR: $($q.Count - $qbad)/$($q.Count) matrices idénticas al codificador del sitio"
  $wb.Close($false)
  if ($bad -gt 0 -or $qbad -gt 0) { throw 'Las pruebas fallaron: no se generan descargas.' }

  # ---------- Libros y complementos ----------
  foreach ($b in $books) {
    $dir = Join-Path $work $b.zip
    New-Item -ItemType Directory -Force $dir | Out-Null
    Copy-Item "$work\$($b.mod).bas" $dir
    $readme = [IO.File]::ReadAllText("$PSScriptRoot\leeme\$($b.readme)") -replace "`r?`n", "`r`n"
    $readmeName = if ($b.lang -eq 'es') { 'LEEME.txt' } else { 'README.txt' }
    [IO.File]::WriteAllText("$dir\$readmeName", $readme, (New-Object Text.UTF8Encoding $true))

    # Complemento (.xlam)
    $wb = New-Book $xl @($b.mod)
    Set-DocProp $wb 'Title' $b.title
    Set-DocProp $wb 'Author' 'Edwin Ortiz Herazo'
    Set-DocProp $wb 'Comments' 'https://www.edwinortiz.net/'
    $wb.IsAddin = $true
    $wb.SaveAs("$dir\$($b.mod).xlam", 55)
    $wb.Close($false)

    # Libro de ejemplo (.xlsm)
    $wb = New-Book $xl @($b.mod)
    $ws = $wb.Worksheets.Item(1)
    $es = $b.lang -eq 'es'
    $ws.Name = if ($es) { 'Ejemplos' } else { 'Examples' }
    if ($b.mod -eq 'NumerosALetras') {
      $fn = if ($es) { 'NUMEROALETRAS' } else { 'NUMBERTOWORDS' }
      Set-Header $ws ($b.title) ($(if ($es) { 'Cambia los valores de la columna A: las letras se actualizan solas. Funciona en cualquier libro al importar NumerosALetras.bas.' } else { 'Change the values in column A and the words update. Import NumerosALetras.bas to use it in any workbook.' })) `
        @($(if ($es) { 'Valor' } else { 'Value' }), "=$fn(A)", "=$fn(A; $(if ($es) { 'VERDADERO' } else { 'TRUE' }))")
      $vals = @(1, 21, 100, 1001, 2026, 1250000.5, 1000000, 21000000, 999999999999999, 0.75)
      $vals += $(if ($es) { '1.250.000,50' } else { '1,250,000.50' })
      for ($i = 0; $i -lt $vals.Count; $i++) {
        $r = 5 + $i
        if ($vals[$i] -is [string]) { $ws.Cells.Item($r, 1).NumberFormat = '@'; $ws.Cells.Item($r, 1).Formula = [string]$vals[$i] }
        else { $ws.Cells.Item($r, 1).Formula = ([double]$vals[$i]).ToString([Globalization.CultureInfo]::InvariantCulture); $ws.Cells.Item($r, 1).NumberFormat = '#,##0.00' }
        $ws.Cells.Item($r, 2).Formula = "=$fn(A$r)"
        $ws.Cells.Item($r, 3).Formula = "=$fn(A$r,TRUE)"
      }
      $ws.Columns.Item('A').ColumnWidth = 22
      $ws.Columns.Item('B').ColumnWidth = 60
      $ws.Columns.Item('C').ColumnWidth = 70
      $ws.Range('B5:C15').WrapText = $true
    } else {
      Set-Header $ws ($b.title) ($(if ($es) { 'Escribe un texto o enlace en la columna A: el QR de la columna B se actualiza. Macro GenerarQR (Alt+F8) para crearlos en lote.' } else { 'Type a text or link in column A and the QR code in column B updates. Run the GenerarQR macro (Alt+F8) to create them in bulk.' })) `
        @($(if ($es) { 'Texto o enlace' } else { 'Text or link' }), '=QR(A)', $(if ($es) { 'Nivel H (30 %)' } else { 'Level H (30%)' }))
      $texts = @('https://www.edwinortiz.net/', 'WIFI:T:WPA;S:MiRed;P:clave123;;', 'ACTIVO-000123 | Portátil | Sala 2', 'Factura N° 001 — José Pérez')
      for ($i = 0; $i -lt $texts.Count; $i++) {
        $r = 5 + $i
        $ws.Cells.Item($r, 1).Value2 = $texts[$i]
        $ws.Rows.Item($r).RowHeight = 110
        $ws.Cells.Item($r, 2).Formula = "=QR(A$r)"
        $ws.Cells.Item($r, 3).Formula = "=QR(A$r,""H"")"
      }
      $ws.Columns.Item('A').ColumnWidth = 40
      $ws.Columns.Item('B').ColumnWidth = 22
      $ws.Columns.Item('C').ColumnWidth = 22
      $ws.Range('A5:A8').VerticalAlignment = -4108
      $ws.Range('A5:A8').WrapText = $true
    }
    $ws.Rows.Item(2).WrapText = $false
    $xl.CalculateFull()
    $check = $ws.Range('B5').Text
    $cellErrors = @(foreach ($cell in $ws.Range('B5:C15').Cells) { if ([string]$cell.Text -like '#*') { $cell.Address($false, $false) } })
    if ($cellErrors.Count -gt 0) { throw "Errores en las celdas de ejemplo: $($cellErrors -join ', ')" }
    Set-DocProp $wb 'Title' $b.title
    Set-DocProp $wb 'Author' 'Edwin Ortiz Herazo'
    $ws.Range('A5').Select() | Out-Null
    $wb.SaveAs("$dir\$($b.example)", 52)
    $shapes = $ws.Shapes.Count
    $wb.Close($false)
    "$($b.zip): ejemplo B5='$check' formas=$shapes"
    if ($b.mod -eq 'CodigoQR' -and $shapes -lt 8) { throw 'El ejemplo de QR no dibujó los códigos.' }
  }
} finally {
  $xl.Quit()
  [void][Runtime.InteropServices.Marshal]::ReleaseComObject($xl)
}
