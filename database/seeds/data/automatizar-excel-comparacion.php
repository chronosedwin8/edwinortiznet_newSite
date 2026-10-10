<?php

declare(strict_types=1);

// "Power Query, VBA, Office Scripts o Python: ¿cuál es la mejor forma de automatizar Excel?" Prueba del 9 de octubre de 2026: 12 libros de 10.000
// filas consolidados con Power Query (6,7 s; 3,7 s al actualizar), VBA (7,5 s) y Python con pandas (7,0 s), todos con 120.000 filas y suma de
// Valor 11.111.254.600, en Windows con Excel 16 y Python 3 (pandas 2.3). Los scripts de Office Scripts NO se ejecutaron (requieren Excel en la web
// y Power Automate); los límites citados vienen de la documentación de Microsoft. Python en Excel: sin acceso a archivos locales (Microsoft).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/automatizar-excel-comparacion/' . $name;
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
<p>"¿Cuál es la mejor forma de automatizar Excel?" es una pregunta que casi siempre recibe una respuesta incorrecta, porque está mal planteada. No hay una "mejor" herramienta: hay una herramienta adecuada para tu tarea, tu equipo, tu licencia y la persona que va a mantener la solución dentro de dos años. Para que la comparación sea concreta, <strong>resolví la misma tarea con cuatro herramientas</strong>: consolidar 12 libros mensuales de ventas (120.000 filas) en una sola tabla.</p>
<p>En este artículo te muestro el código de cada alternativa, los tiempos que medí, los requisitos reales de cada una (con sus límites) y una <strong>matriz de decisión</strong> para elegir. Una aclaración: el título habla de 2027, pero solo puedo afirmar lo que existe y verifiqué a 9 de octubre de 2026; las herramientas cambian, el método de decidir no.</p>
<p class="notice"><strong>Resumen.</strong> En mi prueba, Power Query (6,7 s; 3,7 s al actualizar), VBA (7,5 s) y Python con pandas (7,0 s) consolidaron 120.000 filas con exactamente el mismo resultado. La velocidad no decide: decide dónde corre, quién lo mantiene y qué más necesitas (formato, correos, flujos en la nube). Regla práctica: usa la herramienta más simple que resuelva el problema.</p>

<h2>La tarea: consolidar 12 libros mensuales</h2>
<p>Cada libro (<code>ventas-2026-01.xlsx</code> a <code>ventas-2026-12.xlsx</code>) tiene una hoja con cinco columnas (Fecha, Vendedor, Producto, Cantidad, Valor) y 10.000 filas. El objetivo es una tabla consolidada de 120.000 filas, con los tipos de dato correctos, que se pueda repetir cuando llegue un nuevo mes. Verifiqué el resultado con una suma de control: el total de Valor debe ser <strong>11.111.254.600</strong>. Lo probé en Windows con Excel 16 y Python 3 con pandas 2.3.</p>
{{img:tiempos}}

<h2>Opción 1: Power Query (sin escribir código en la hoja)</h2>
<p>Power Query es el conector de datos de Excel: <em>Datos &gt; Obtener datos &gt; Desde un archivo &gt; Desde la carpeta</em>. Se define una vez y se actualiza con un clic. Este es el código M (Editor avanzado) que usé:</p>
<pre><code>let
    Origen = Folder.Files("C:\RUTA\datos"),
    Solo = Table.SelectRows(Origen, each [Extension] = ".xlsx" and not Text.StartsWith([Name], "~$")),
    Leer = Table.AddColumn(Solo, "Datos", each Excel.Workbook([Content], true){0}[Data]),
    Combinado = Table.Combine(Leer[Datos]),
    Tipos = Table.TransformColumnTypes(Combinado,
        {{"Fecha", type date}, {"Vendedor", type text}, {"Producto", type text},
         {"Cantidad", Int64.Type}, {"Valor", type number}})
in
    Tipos</code></pre>
<p><strong>Resultado:</strong> 120.000 filas, suma 11.111.254.600, 6,7 segundos la primera carga y 3,7 al actualizar. <strong>Ventajas:</strong> sin macros, auditable (cada paso queda registrado), se actualiza agregando el archivo del mes nuevo a la carpeta. <strong>Límites:</strong> no formatea ni envía correos; está pensado para importar, limpiar y combinar datos. Lo explico a fondo, con el caso de las fechas y los valores en pesos, en el artículo sobre <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">cómo importar un CSV correctamente</a>.</p>

<h2>Opción 2: VBA (macros en el escritorio)</h2>
<p>VBA es el lenguaje de macros de Excel. Sirve para consolidar, pero su fuerte es lo que viene después: dar formato, crear PDF por vendedor, enviar correos. Esta macro, que lee cada archivo en una matriz y la escribe de un golpe, es la versión eficiente:</p>
<pre><code>Sub Consolidar(ByVal carpeta As String)
    Dim destino As Worksheet, archivo As String, wb As Workbook
    Dim datos As Variant, fila As Long, n As Long
    Application.ScreenUpdating = False
    Application.Calculation = xlCalculationManual
    Set destino = ThisWorkbook.Worksheets("Consolidado")
    destino.Cells.Clear
    destino.Range("A1:E1").Value = Array("Fecha", "Vendedor", "Producto", "Cantidad", "Valor")
    fila = 2
    archivo = Dir(carpeta & "\ventas-2026-*.xlsx")
    Do While archivo <> ""
        Set wb = Workbooks.Open(carpeta & "\" & archivo, ReadOnly:=True, UpdateLinks:=0)
        With wb.Worksheets(1).UsedRange
            n = .Rows.Count - 1
            If n > 0 Then
                datos = .Offset(1, 0).Resize(n, 5).Value2   ' sin encabezado
                destino.Cells(fila, 1).Resize(n, 5).Value2 = datos
                fila = fila + n
            End If
        End With
        wb.Close SaveChanges:=False
        archivo = Dir()
    Loop
    destino.Range("A:A").NumberFormat = "dd/mm/yyyy"
    Application.Calculation = xlCalculationAutomatic
    Application.ScreenUpdating = True
End Sub</code></pre>
<p><strong>Resultado:</strong> 120.000 filas, suma 11.111.254.600, 7,5 segundos. <strong>Ventajas:</strong> control total del proceso y de la presentación; hay mucho conocimiento en español. <strong>Límites:</strong> solo funciona en Excel de escritorio (no en Excel para la web), el archivo debe guardarse como .xlsm y Microsoft bloquea por defecto las macros de archivos descargados de internet, así que quien las reciba tiene que desbloquearlas; además, requiere disciplina de mantenimiento (comentarios, versiones). Para ver macros listas para usar, mira <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a> y las plantillas de la sección de Excel.</p>

<h2>Opción 3: Office Scripts (Excel en la nube) y Power Automate</h2>
<p>Office Scripts es el equivalente moderno de las macros, escrito en TypeScript, para Excel en la web (y versiones recientes de escritorio, según Microsoft). Un punto clave: <strong>un script trabaja sobre el libro en el que se ejecuta</strong>; para recorrer una carpeta de archivos se orquesta con Power Automate: un flujo lista los archivos, ejecuta el script de lectura en cada uno y luego un script de escritura en el libro consolidado. Este es el patrón (escrito a partir de la documentación; <strong>no lo ejecuté</strong>, porque requiere Excel en la web, OneDrive o SharePoint y Power Automate):</p>
<pre><code>// Script 1 (se ejecuta en cada libro mensual): devuelve los datos sin el encabezado
function main(workbook: ExcelScript.Workbook): (string | number | boolean)[][] {
  const hoja = workbook.getWorksheets()[0];
  return hoja.getUsedRange().getValues().slice(1);
}

// Script 2 (se ejecuta en el libro consolidado): agrega un lote de filas
function main(workbook: ExcelScript.Workbook, filas: (string | number | boolean)[][]) {
  const hoja = workbook.getWorksheet("Consolidado");
  const siguiente = hoja.getUsedRange().getRowCount();
  hoja.getRangeByIndexes(siguiente, 0, filas.length, filas[0].length).setValues(filas);
}</code></pre>
<p><strong>Ventajas:</strong> corre en la nube sin que tu computador esté encendido, se programa y se integra con Teams, correo y SharePoint. <strong>Límites que Microsoft documenta:</strong> las solicitudes y respuestas en Excel para la web se limitan a 5 MB, hay 1.600 llamadas por día y por usuario a la acción "Ejecutar script" y un tiempo máximo de 120 segundos en operaciones síncronas de Power Automate; usar Office Scripts con Power Automate requiere una licencia empresarial de Microsoft 365. Para 120.000 filas hay que enviar lotes. Es una solución para equipos que ya trabajan en SharePoint y Power Automate, no para una pyme con un computador y archivos locales.</p>

<h2>Opción 4: Python (dentro y fuera de Excel)</h2>
<p>Hay dos cosas distintas. <strong>Python en Excel</strong> (la función <code>=PY()</code>) corre en la nube de Microsoft, en un entorno aislado sin acceso a tus archivos locales ni a la red: los datos entran solo con la función <code>xl()</code> y no puedes instalar paquetes propios, solo los de la distribución curada de Anaconda. Por eso <strong>no puede consolidar una carpeta</strong>: sirve para analizar y graficar los datos que ya están en el libro (por ejemplo, la tabla que dejó Power Query). Y <strong>Python fuera de Excel</strong> (en tu computador o en un servidor) sí lee archivos y es la opción para grandes volúmenes y tareas programadas:</p>
<pre><code>import glob
import pandas as pd

archivos = sorted(glob.glob(r"C:\RUTA\datos\ventas-2026-*.xlsx"))
df = pd.concat((pd.read_excel(a) for a in archivos), ignore_index=True)

print(len(df), int(df["Valor"].sum()))                 # 120000 11111254600
print(df.groupby("Vendedor")["Valor"].sum().sort_values(ascending=False))
df.to_excel("consolidado.xlsx", index=False)</code></pre>
<p><strong>Resultado:</strong> 120.000 filas, suma 11.111.254.600, 7,0 segundos. <strong>Ventajas:</strong> potente para análisis, estadística y volúmenes mayores; el código es corto y reutilizable. <strong>Límites:</strong> hay que instalar Python y pandas y mantener el entorno, y no es lo que la mayoría de oficinas tiene a la mano.</p>
{{img:requisitos}}

<h2>Matriz de decisión: ¿cuál elijo?</h2>
<p>Este es el recurso aplicable. Responde estas preguntas en orden y quédate con la primera herramienta que resuelva tu caso:</p>
<table>
<thead><tr><th>Si tu necesidad es…</th><th>Elige</th><th>Por qué</th></tr></thead>
<tbody>
<tr><td>Traer, limpiar y combinar datos de archivos, carpetas o bases, y repetirlo cada mes</td><td><strong>Power Query</strong></td><td>Sin código en la hoja, auditable, se actualiza con un clic.</td></tr>
<tr><td>Dar formato, generar PDF, enviar correos o ejecutar un proceso paso a paso en el escritorio</td><td><strong>VBA</strong></td><td>Control total del entorno de escritorio y mucha documentación.</td></tr>
<tr><td>Que el proceso corra en la nube, sin tu computador, integrado con SharePoint, Teams o correo</td><td><strong>Office Scripts + Power Automate</strong></td><td>Orquestación en la nube, con sus límites y licencia empresarial.</td></tr>
<tr><td>Analizar, modelar o graficar datos ya cargados en el libro</td><td><strong>Python en Excel</strong> (si tu plan lo incluye)</td><td>Pandas y gráficos sin salir de Excel, pero sin acceso a archivos locales.</td></tr>
<tr><td>Volúmenes muy grandes, tareas programadas o procesamiento fuera de Excel</td><td><strong>Python fuera de Excel</strong></td><td>Flexible y escalable, con mantenimiento propio.</td></tr>
<tr><td>Reglas fijas y repetibles, pero sin saber programar</td><td><strong>Una plantilla ya hecha</strong></td><td>La solución más rápida y barata si existe y encaja.</td></tr>
</tbody>
</table>
<p>Y cuatro preguntas de desempate: <strong>1) ¿Quién lo mantendrá dentro de dos años?</strong> (si solo tú sabes cómo funciona, es un riesgo). <strong>2) ¿Dónde corre?</strong> (escritorio, web, servidor). <strong>3) ¿Qué licencia tienes?</strong> (algunas funciones requieren planes empresariales). <strong>4) ¿Qué pasa si falla?</strong> (¿es auditable y reversible?, lo trato en el artículo sobre <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a>).</p>

<h2>Colombia, Latinoamérica y el mundo: dónde importa cada opción</h2>
<p>En el mundo corporativo, la tendencia es combinar: Power Query para los datos, Python o BI para el análisis y flujos en la nube para la orquestación. En Colombia y buena parte de Latinoamérica, la realidad de muchas pymes, oficinas contables y colegios es otra: Excel de escritorio sobre Windows, archivos locales, a veces sin licencia empresarial. Por eso, en mi experiencia, <strong>Power Query y VBA resuelven la mayoría de los casos reales</strong>: están en el Excel que ya tienes y existe mucha documentación en español. Office Scripts y Python en Excel brillan cuando hay licencias empresariales y trabajo en la nube. Para un <strong>contador</strong>, Power Query para conciliar y VBA para generar documentos; para un <strong>docente</strong>, Power Query para unir listas de cursos y plantillas con macros para boletines; para un <strong>gerente</strong>, lo más importante es que el proceso no dependa de una sola persona.</p>

<h2>Herramientas para automatizar sin empezar de cero</h2>
<p>Si el proceso que necesitas ya existe como macro probada, ahórrate meses de desarrollo. <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Enviar correos masivos con adjuntos y copias CC y CCO</a> y <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Combinar correspondencia y generar PDF individuales</a> son aplicaciones en VBA listas para usar desde tus listas de Excel; y si quieres adaptar la lógica a tu caso, la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a> te acompaña. Para empezar con IA y macros gratuitas, descarga el <a href="/descargas/excel-con-ia/excel-con-ia.zip">kit Excel con IA</a>, y aprende más en mi <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">lista de Excel en YouTube</a>.</p>
{{productos:enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,combinar-correspondencia-y-generar-pdf-individuales}}
<p>Sigue leyendo: <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">cómo automatizar tareas en Excel y reducir errores</a> y <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿VBA está obsoleto?</h3>
<p>No. Sigue funcionando y es muy útil en Excel de escritorio. Pero no corre en Excel para la web ni en la nube, y Microsoft bloquea por defecto las macros de archivos descargados de internet. Para tareas en la nube existen Office Scripts y Power Automate.</p>
<h3>¿Power Query reemplaza a las macros?</h3>
<p>Para importar, limpiar y combinar datos, casi siempre sí y con ventajas. Para dar formato, enviar correos o generar documentos, no: ahí siguen las macros.</p>
<h3>¿Puede Python en Excel leer archivos de mi computador?</h3>
<p>No. Corre en la nube de Microsoft en un entorno aislado sin acceso a archivos locales; los datos entran con xl(). Para leer archivos usa Power Query o Python fuera de Excel.</p>
<h3>¿Necesito saber programar para automatizar Excel?</h3>
<p>No siempre. Power Query se maneja con una interfaz gráfica, y existen plantillas listas. Programar ayuda cuando el proceso es único o complejo.</p>
<h3>¿Cuál es más rápido?</h3>
<p>En mi prueba con 120.000 filas, los tiempos fueron muy parecidos (entre 6,7 y 7,5 segundos; Power Query baja a 3,7 al actualizar). La velocidad rara vez es el criterio: importa más dónde corre y quién lo mantiene.</p>

<p class="notice"><strong>Elige con la matriz.</strong> Anota una tarea repetitiva de tu trabajo, responde las cuatro preguntas de desempate y escoge la herramienta más simple que la resuelva. Si ya existe como plantilla, empieza por ahí: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">correos masivos con adjuntos</a> o <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">PDF individuales</a>.</p>

<h2>Para pensar</h2>
<p>Cada vez que automatizamos una tarea, la escondemos: el proceso deja de ser visible y pasa a depender de quien lo construyó. <strong>Si la mejor automatización es la que nadie nota, ¿cómo evitamos que se convierta en una caja negra que nadie entiende, y quién debería responder cuando falle: quien la programó, quien la usa o quien decidió no documentarla?</strong> ¿Y vale la pena aprender la herramienta de moda o la que seguirá funcionando cuando la moda cambie?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tiempos}}' => $img('automatizar-excel-comparacion-tiempos', 436, 'Gráfico de barras con los tiempos de consolidar 12 libros de 120.000 filas: Power Query 6,7 segundos en la primera carga y 3,7 al actualizar, Python con pandas 7,0 y VBA 7,5.', 'Tiempos medidos al consolidar 12 libros (120.000 filas). Los tres métodos dieron el mismo resultado.'),
    '{{img:requisitos}}' => $img('automatizar-excel-comparacion-requisitos', 553, 'Tabla con dónde corre cada herramienta y para qué sirve mejor: Power Query en Excel de escritorio, VBA en el escritorio, Office Scripts en Excel para la web con Power Automate, Python en Excel en la nube de Microsoft y Python fuera de Excel en tu equipo o un servidor.', 'Dónde corre cada herramienta y para qué sirve mejor.'),
]);

return [
    'slug' => 'automatizar-excel-power-query-vba-office-scripts-python-comparacion',
    'title' => 'Power Query, VBA, Office Scripts o Python: ¿cuál es la mejor forma de automatizar Excel en 2027?',
    'excerpt' => 'La misma tarea (consolidar 12 libros de 120.000 filas) resuelta con Power Query, VBA, Python y Office Scripts, con tiempos medidos, requisitos reales y una matriz de decisión para elegir.',
    'seo_title' => 'Power Query, VBA, Office Scripts o Python: ¿cuál elegir?',
    'seo_description' => 'Comparamos Power Query, VBA, Office Scripts y Python resolviendo la misma tarea en Excel, con código, tiempos medidos y una matriz para decidir.',
    'focus_keyword' => 'automatizar Excel',
    'cover' => '/assets/img/articulos/automatizar-excel-comparacion/automatizar-excel-comparacion-portada',
    'cover_alt' => 'Portada "Power Query, VBA, Office Scripts o Python: ¿cuál automatiza mejor tu Excel?" con una tarjeta de lo mejor de cada herramienta: datos, escritorio, nube y flujos, y análisis.',
    'published_at' => '2026-10-29 12:00:00',
    'content_html' => $html,
];
