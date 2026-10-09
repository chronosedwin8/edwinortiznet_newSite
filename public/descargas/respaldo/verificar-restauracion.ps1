param(
    [Parameter(Mandatory)][string]$Origen,
    [Parameter(Mandatory)][string]$Restaurado
)

function Get-Huellas($raiz) {
    $raiz = (Resolve-Path $raiz).Path.TrimEnd('\')
    $d = @{}
    Get-ChildItem $raiz -Recurse -File | ForEach-Object {
        $d[$_.FullName.Substring($raiz.Length + 1)] = (Get-FileHash $_.FullName -Algorithm SHA256).Hash
    }
    return $d
}

$a = Get-Huellas $Origen
$b = Get-Huellas $Restaurado
$faltan    = @($a.Keys | Where-Object { -not $b.ContainsKey($_) })
$distintos = @($a.Keys | Where-Object { $b.ContainsKey($_) -and $a[$_] -ne $b[$_] })
$sobran    = @($b.Keys | Where-Object { -not $a.ContainsKey($_) })

"Archivos en el origen: $($a.Count) | restaurados: $($b.Count)"
"Faltan: $($faltan.Count) | Distintos (corruptos o modificados): $($distintos.Count) | Sobran: $($sobran.Count)"
$faltan    | ForEach-Object { "  FALTA      $_" }
$distintos | ForEach-Object { "  DISTINTO   $_" }
$sobran    | ForEach-Object { "  SOBRA      $_" }
if ($faltan.Count + $distintos.Count -eq 0) { "RESTAURACION VERIFICADA" } else { "RESTAURACION CON PROBLEMAS: no confies en este respaldo hasta corregirlo" }
