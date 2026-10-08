<?php

declare(strict_types=1);

// Artículo práctico: Copilot y agentes en Excel (lenguaje natural en la cuadrícula, clasificación, resúmenes,
// agentes, Copilot Pages, licencias, privacidad y verificación), con escenarios para pymes, finanzas, talento
// humano, docentes, directivos y analistas. Estado verificado el 8 de octubre de 2026 con fuentes enlazadas.
// El texto va en nowdoc para que las fórmulas ($, <, &) no se interpreten; los bloques <pre><code> se escapan
// automáticamente y las figuras se insertan con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/copilot-excel/' . $name;
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
<p>Hace un año, la promesa sonaba perfecta: escribir en una celda <code>=COPILOT("Clasifica este comentario"; B2)</code>, arrastrar hacia abajo y ver cómo la inteligencia artificial llenaba mil filas. Muchos colegas me escribieron emocionados. Hoy esa función ya no existe, y no porque la idea fuera mala, sino porque Microsoft decidió llevar el lenguaje natural a otro lugar: un panel de Copilot que ya no solo responde, sino que <strong>planea, edita el libro, crea columnas, fórmulas y tablas dinámicas, y trabaja con agentes</strong>.</p>
<p>En esta guía te cuento, con fuentes verificadas el 8 de octubre de 2026, qué hay hoy en Excel, cómo pedirle a Copilot que clasifique y resuma, qué agentes existen y para qué sirve Copilot Pages. Sobre todo, te dejo prompts exactos, fórmulas en español y código para pymes, contadores, talento humano, docentes, directivos y analistas, porque una herramienta que no se prueba con un caso real es solo una noticia.</p>

{{img:flujo}}

<h2>Qué hay hoy en Excel (octubre de 2026)</h2>
<p>Microsoft cambia nombres y botones casi cada mes, así que empiezo por el mapa. Esto es lo vigente, con su fuente:</p>
<table>
<thead><tr><th>Función</th><th>Qué hace</th><th>Estado</th></tr></thead>
<tbody>
<tr><td>Copilot Chat en Excel</td><td>Responde preguntas, explica fórmulas y resume datos sin modificar el libro</td><td>Disponible en el panel de Copilot</td></tr>
<tr><td>Modo agente</td><td>Edita el libro en varios pasos: columnas, fórmulas, tablas dinámicas, gráficos</td><td>Disponible de forma general desde enero de 2026; predeterminado desde abril</td></tr>
<tr><td>Modo plan</td><td>Muestra los pasos y los datos que usará antes de tocar la hoja</td><td>Disponible de forma general desde mayo de 2026</td></tr>
<tr><td>Elección de modelo</td><td>Auto, o modelos de OpenAI y Anthropic elegidos por ti</td><td>Disponible; Grok, en el programa Frontier</td></tr>
<tr><td>Personalización y reglas del libro</td><td>Instrucciones fijas tuyas o una hoja <em>.Rules</em> que viaja con el archivo</td><td>Disponibles desde junio de 2026</td></tr>
<tr><td>Historial de cambios con Copilot</td><td>Explica qué cambió, quién lo cambió y deshace ediciones puntuales</td><td>Disponible desde el 1 de septiembre de 2026</td></tr>
<tr><td>Función <code>=COPILOT()</code></td><td>Llamaba a la IA desde una celda</td><td>Retirada el 14 de septiembre de 2026</td></tr>
</tbody>
</table>
<p>Los detalles: el modo agente llegó a Excel para la web en diciembre de 2025 y a Windows el 27 de enero de 2026, con un selector de modelos de OpenAI y Anthropic, según el <a href="https://techcommunity.microsoft.com/blog/excelblog/agent-mode-in-excel-is-now-generally-available-on-desktop/4457408" target="_blank" rel="noopener">blog oficial de Excel</a>. El 22 de abril de 2026, Microsoft anunció que estas capacidades pasaban a ser <a href="https://www.microsoft.com/en-us/microsoft-365/blog/2026/04/22/copilots-agentic-capabilities-in-word-excel-and-powerpoint-are-generally-available/" target="_blank" rel="noopener">la experiencia predeterminada en Word, Excel y PowerPoint</a> para Microsoft 365 Copilot, Premium, Personal y Familia. El <a href="https://www.microsoft.com/en-us/microsoft-365/roadmap?searchterms=560338" target="_blank" rel="noopener">modo plan</a> se lanzó en mayo, y en julio se sumaron <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-july-2026/4523403" target="_blank" rel="noopener">GPT-5.6 y Claude Opus 5</a>, además del soporte para libros con Autoguardado desactivado en Windows y Mac. Desde febrero, el modo agente también trabaja con <a href="https://techcommunity.microsoft.com/blog/microsoft365insiderblog/agent-mode-in-excel-now-works-with-your-local-files/4497675" target="_blank" rel="noopener">archivos guardados en tu equipo</a>.</p>

<h2>¿Qué pasó con =COPILOT() y cómo se hace lo mismo hoy?</h2>
<p>La <a href="https://support.microsoft.com/office/copilot-function-5849821b-755d-4030-a38b-9e20be0cbf62" target="_blank" rel="noopener">página de soporte de Microsoft</a> es clara: desde el 14 de septiembre de 2026 la función ya no está disponible; los resultados que ya estaban calculados se conservan como valores en caché, pero al recalcular la celda aparece <em>#¿NOMBRE?</em>. Nunca salió de la vista previa de los programas Insider y Frontier. Microsoft recomienda usar el panel de Copilot, que resume texto, clasifica datos, genera contenido y busca en la web.</p>
<p>Si tienes un libro con esa función, haz esto antes de que alguien presione F9: copia la columna y pégala como valores, y deja una nota con la fecha y el prompt que se usó. Luego, rehaz la tarea así:</p>
<pre><code>Antes (beta retirada):
=COPILOT("Clasifica en Entrega, Precio, Pagos, Servicio o Inventario"; B2)

Ahora, en el panel de Copilot con el modo agente:
En la tabla Comentarios agrega una columna Tema que clasifique cada
comentario en UNA de estas categorías: Entrega, Precio, Pagos,
Servicio, Inventario u Otro. Agrega otra columna Sentimiento con
Positivo, Neutro o Negativo. No modifiques la columna Comentario.
Muéstrame primero el plan. Al final crea, en una hoja nueva, una tabla
dinámica con el conteo por Tema y Sentimiento.</code></pre>
<p>La diferencia de fondo es importante: la función se recalculaba y podía cambiar de respuesta; el resultado del modo agente queda escrito en la hoja como datos que puedes auditar, filtrar y comparar. Para textos largos, Microsoft documenta además cómo <a href="https://support.microsoft.com/topic/cecc7821-39c1-4e12-8bd6-4d4348370585" target="_blank" rel="noopener">obtener temas, sentimiento y resúmenes</a> de una columna de texto, con citas numeradas que señalan las filas de origen.</p>

<h2>Clasificar y resumir con lenguaje natural: tres prompts y lo que debes esperar</h2>
<p>Supón una tabla <em>Comentarios</em> con 1.200 respuestas de clientes de una tienda. Estos son los prompts que uso, en orden:</p>
<pre><code>1) Explorar (Copilot Chat, sin editar):
¿Cuáles son los cinco temas más frecuentes en Comentarios[Comentario]?
Dame para cada uno un ejemplo textual y el número aproximado de filas.

2) Clasificar (modo agente):
Con esos cinco temas más "Otro", agrega la columna Tema. Si un
comentario toca dos temas, elige el principal y escribe el segundo en
la columna Tema2. Marca con "Revisar" los que no entiendas.

3) Resumir para decidir:
Escribe en la hoja Resumen tres hallazgos con su cifra, citando el
rango de donde sale cada número, y dos acciones concretas para el mes.</code></pre>
<p>La salida esperada es una columna <em>Tema</em> con valores como <em>Entrega</em>, <em>Pagos</em> u <em>Otro</em>; una tabla dinámica con, por ejemplo, 412 comentarios de <em>Entrega</em>, 318 de ellos negativos, y un párrafo del tipo «el 34 % de los comentarios menciona demoras en la entrega, concentradas en pedidos de fin de semana». Ahora viene lo que separa a un profesional de un aficionado: <strong>comprobar</strong>. Estas fórmulas no dependen de la IA:</p>
<pre><code>Filas sin clasificar:        =CONTAR.BLANCO(Comentarios[Tema])
Categorías inventadas:       =SUMA(--ESNA(COINCIDIRX(Comentarios[Tema]; Categorias[Tema])))
Cuadre con la tabla dinámica: =FILAS(Comentarios) - Resumen!B10   (B10: total general)
Muestra de 20 para leer:     =TOMAR(ORDENARPOR(Comentarios; MATRIZALEAT(FILAS(Comentarios))); 20)</code></pre>
<p>En inglés: COUNTBLANK, ISNA, XMATCH, ROWS, TAKE, SORTBY y RANDARRAY. Si la segunda fórmula no da cero, Copilot creó una categoría que no pediste; si la tercera no da cero, la tabla dinámica no cubre todas las filas. Y leer veinte comentarios al azar con su etiqueta te dice en cinco minutos si la clasificación tiene sentido.</p>
<p>¿Y si no tienes Copilot? Para categorías con palabras clave estables, una fórmula clásica es gratis, instantánea y siempre da lo mismo. Con una tabla <em>Palabras</em> (columnas Palabra y Tema):</p>
<pre><code>=LET(t; MINUSC([@Comentario]);
     hit; ESNUMERO(HALLAR(Palabras[Palabra]; t));
     SI.ERROR(INDICE(FILTRAR(Palabras[Tema]; hit); 1); "Revisar"))</code></pre>
<p>Funciona en Microsoft 365 y en Excel 2021 (LET, FILTRAR). La IA queda entonces para lo que de verdad requiere entender el lenguaje: ironía, quejas mezcladas, comentarios sin palabras clave.</p>

<h2>Antes de pedir: reglas que Copilot obedece siempre</h2>
<p>Desde junio de 2026 puedes escribir tus preferencias una sola vez. La <a href="https://techcommunity.microsoft.com/blog/excelblog/new-ways-to-customize-how-copilot-edits-your-workbooks/4527307" target="_blank" rel="noopener">personalización</a> guarda reglas tuyas para todos los libros, y las <strong>reglas del libro</strong> viven en una hoja cuyo nombre termina en <em>.Rules</em>, con una regla por fila en la columna A. Esta es la que pongo en mis plantillas:</p>
<pre><code>Hoja: Plantilla.Rules (columna A)
Nunca combines celdas; usa "Centrar en la selección".
Escribe fórmulas con referencias estructuradas de tabla, no rangos fijos.
Usa nombres de funciones en español y punto y coma como separador.
No pegues valores donde debe ir una fórmula.
Formato de moneda: $ #.##0 sin decimales.
Toda hoja de resumen lleva una celda "Control" que compare su total
con el total de la tabla de origen.
Nunca escribas nombres de estudiantes ni de empleados: usa el código.</code></pre>
<p>Como la hoja viaja con el archivo, todo el que use Copilot en ese libro sigue las mismas reglas. Para un colegio o una pyme con varias personas editando, esto vale oro.</p>

<h2>Escenarios prácticos paso a paso</h2>
<h3>Pymes: ventas e inventario</h3>
<p>Una tienda con tablas <em>Ventas</em> (Fecha, Producto, Categoría, Unidades, Total) e <em>Inventario</em> (Producto, Existencias, Costo). Este es un prompt orientado al resultado, como recomienda Microsoft:</p>
<pre><code>Usa las tablas Ventas e Inventario. Primero muéstrame el plan. Luego:
1) Crea una hoja Resumen con el total vendido por categoría y mes,
   con fórmulas (nada de valores pegados).
2) En Inventario agrega "Días de inventario" según la venta diaria
   promedio de los últimos 90 días.
3) Resalta en rojo los productos con menos de 15 días.
4) Agrega una celda Control que compare el total del resumen con
   SUMA(Ventas[Total]) y debe dar 0.</code></pre>
<p>Lo que deberías ver en la hoja, y lo que debes revisar fórmula por fórmula:</p>
<pre><code>Resumen (A3):
=PIVOTARPOR(Ventas[Categoría]; TEXTO(Ventas[Fecha]; "aaaa-mm"); Ventas[Total]; SUMA)

Días de inventario (columna en Inventario):
=LET(prom; SUMAR.SI.CONJUNTO(Ventas[Unidades]; Ventas[Producto]; [@Producto];
                              Ventas[Fecha]; ">=" & HOY() - 90) / 90;
     SI(prom = 0; "Sin ventas"; REDONDEAR([@Existencias] / prom; 0)))

Control:
=SUMA(Ventas[Total]) - TOMAR(A3#; -1; -1)</code></pre>
<p>En inglés: PIVOTBY, TEXT, SUMIFS, TODAY, ROUND y TAKE (en inglés el formato es "yyyy-mm"). Si el control no da cero, no presentes el informe. Y cuando el análisis te diga qué productos rotan, el siguiente paso suele ser operativo: etiquetar el inventario con el <a href="/producto/generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras/">generador de etiquetas con QR y códigos de barras</a> o facturar con la <a href="/producto/factura-con-envio-por-correo-al-cliente/">factura con envío por correo al cliente</a>. Ahí no hace falta IA: hace falta una plantilla que no falle.</p>

<h3>Finanzas y contabilidad: conciliación bancaria</h3>
<p>Con las tablas <em>Banco</em> y <em>Libro</em>, el prompt:</p>
<pre><code>Concilia Banco contra Libro por Referencia y Valor. Agrega en Banco
la columna Estado con Conciliado, Pendiente o Duplicado en libro.
Usa fórmulas, no valores. Luego explícame las 10 partidas pendientes
de mayor valor y qué patrón ves (fechas, terceros, comisiones).
No borres ni modifiques ninguna fila original.</code></pre>
<p>La fórmula que deberías encontrar en la columna Estado, fácil de auditar:</p>
<pre><code>=LET(n; CONTAR.SI.CONJUNTO(Libro[Referencia]; [@Referencia]; Libro[Valor]; [@Valor]);
     SI(n = 1; "Conciliado"; SI(n = 0; "Pendiente"; "Duplicado en libro")))

Valor pendiente: =SUMAR.SI(Banco[Estado]; "Pendiente"; Banco[Valor])</code></pre>
<p>Si la conciliación se repite cada mes, conviértela en un botón. Este Office Script (TypeScript, pestaña Automatizar de Excel para la web y Windows, con cuenta empresarial o educativa) resalta las partidas sin cruce y cuenta cuántas quedan:</p>
<pre><code>function main(workbook: ExcelScript.Workbook) {
  const banco = workbook.getTable("Banco");
  const libro = workbook.getTable("Libro");
  const clave = (r: (string | number | boolean)[], iRef: number, iVal: number) =>
    `${String(r[iRef]).trim()}|${Number(r[iVal]).toFixed(2)}`;

  const lh = libro.getHeaderRowRange().getValues()[0] as string[];
  const enLibro = new Set(libro.getRangeBetweenHeaderAndTotal().getValues()
    .map(r => clave(r, lh.indexOf("Referencia"), lh.indexOf("Valor"))));

  const bh = banco.getHeaderRowRange().getValues()[0] as string[];
  const cuerpo = banco.getRangeBetweenHeaderAndTotal();
  cuerpo.getFormat().getFill().clear();
  let pendientes = 0;
  cuerpo.getValues().forEach((fila, i) => {
    if (!enLibro.has(clave(fila, bh.indexOf("Referencia"), bh.indexOf("Valor")))) {
      cuerpo.getRow(i).getFormat().getFill().setColor("#FFF2CC");
      pendientes++;
    }
  });
  console.log(`Partidas del banco sin cruce: ${pendientes}`);
}</code></pre>
<p>Y cuando varias personas tocan el mismo libro, la <a href="https://techcommunity.microsoft.com/blog/excelblog/copilot-in-excel-bringing-clarity-to-collaborative-workbooks/4552007" target="_blank" rel="noopener">habilidad de historial de cambios</a> responde preguntas como «¿qué cambió en esta hoja desde el lunes y quién lo hizo?» o «deshaz solo las ediciones de Copilot de la semana pasada y conserva las manuales». En contabilidad, esa trazabilidad vale tanto como la conciliación misma.</p>

<h3>Talento humano: ausentismo y entrevistas de salida</h3>
<p>Aquí la regla de oro es la privacidad: trabaja con códigos, no con nombres ni diagnósticos. Un prompt útil para la columna de texto de las entrevistas de salida:</p>
<pre><code>En EntrevistasSalida[Motivo] identifica los motivos de retiro y
agrúpalos en máximo seis categorías. Agrega la columna Categoría y una
tabla con el conteo por Área y Categoría. No uses ni muestres la
columna Código en el resumen. Señala si alguna área tiene menos de
cinco casos, para no publicar cifras que identifiquen personas.</code></pre>
<p>Para la tasa de ausentismo por área, una sola fórmula:</p>
<pre><code>=LET(a; AGRUPARPOR(Personal[Área];
            APILARH(Personal[Horas ausencia]; Personal[Horas programadas]); SUMA; 0; 0);
     APILARH(INDICE(a;; 1); INDICE(a;; 2) / INDICE(a;; 3)))</code></pre>
<p>En inglés: GROUPBY, HSTACK e INDEX. Y si después debes enviar a cada trabajador su certificado o su desprendible, eso es trabajo de automatización, no de IA: <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">combinar correspondencia y generar PDF individuales</a> y <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">enviar correos masivos con adjuntos</a> lo hacen en minutos.</p>

<h3>Docentes y directivos: notas, asistencia e informes</h3>
<p>Con una tabla <em>Notas</em> (Código, Curso, Área, Nota) y una <em>Escala</em> del SIEE de tu institución, el desempeño se calcula con una fórmula, no con IA:</p>
<pre><code>Desempeño:  =BUSCARX([@Nota]; Escala[Desde]; Escala[Desempeño]; "Sin nota"; -1)

Estudiantes en riesgo (Bajo en 2 o más áreas o inasistencia mayor al 15 %):
=FILTRAR(Resumen[Código]; (Resumen[Áreas en Bajo] >= 2) + (Resumen[% inasistencia] > 0,15); "Nadie en riesgo")</code></pre>
<p>Donde Copilot sí ayuda es en el informe. Este prompt me ahorra una tarde antes de cada comité de evaluación:</p>
<pre><code>Con la tabla Resumen (códigos de estudiante, nunca nombres) redacta
para cada curso un párrafo de máximo 80 palabras para el comité de
evaluación: número de estudiantes en Bajo por área, relación con la
inasistencia y una acción pedagógica concreta. Cita la celda o el
rango de cada cifra. No hagas juicios sobre familias ni diagnósticos.</code></pre>
<p>Un recordatorio que no es opcional: los datos de niñas, niños y adolescentes tienen protección reforzada en el artículo 7 de la <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981" target="_blank" rel="noopener">Ley 1581 de 2012</a>. Usa la cuenta institucional, códigos en lugar de nombres y agrega antes de compartir. Si llevas la asistencia en Excel, mi <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">listado de asistencia laboral o académica</a> ya trae los cálculos listos. Y para el trabajo de aula con IA, preparé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> con prompts probados por área, el <a href="/herramientas/generador-de-examenes/">generador de exámenes con IA</a> (puedes probar la <a href="/examenes/demo/">demostración</a>) y <a href="/herramientas/piar/">PIAR con IA</a> para los ajustes razonables.</p>

<h3>Analistas de datos: Python en Excel más Copilot</h3>
<p><a href="https://support.microsoft.com/office/python-in-excel-availability-781383e6-86b9-4156-84fb-93e786f7cab0" target="_blank" rel="noopener">Python en Excel</a> está disponible para cuentas empresariales en Windows y la web, y en vista previa para Personal y Familia. Dos celdas <code>=PY</code> que uso como punto de partida:</p>
<pre><code># Celda =PY 1: atípicos de Total con el rango intercuartílico
df = xl("Ventas[#Todo]", headers=True)
q1, q3 = df["Total"].quantile([0.25, 0.75])
limite = q3 + 1.5 * (q3 - q1)
df[df["Total"] > limite].sort_values("Total", ascending=False)

# Celda =PY 2: tendencia mensual y proyección de tres meses
import numpy as np
df["Mes"] = pd.to_datetime(df["Fecha"]).dt.to_period("M").astype(str)
m = df.groupby("Mes")["Total"].sum()
x = np.arange(len(m))
pend, corte = np.polyfit(x, m.values, 1)
pd.DataFrame({"Mes": [f"+{i}" for i in (1, 2, 3)],
              "Proyección": [round(corte + pend * (len(m) - 1 + i)) for i in (1, 2, 3)]})</code></pre>
<p>Desde agosto, los Insiders pueden pedirle a Copilot que escriba esas celdas con la <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-august-2026/4527283" target="_blank" rel="noopener">habilidad de Python</a>: «@python-in-excel detecta atípicos en Ventas[Total] por categoría con el método IQR y explícame el código línea por línea». Ojo: según el <a href="https://support.microsoft.com/en-us/excel/copilot/copilot-in-excel-built-in-skills" target="_blank" rel="noopener">soporte de Microsoft</a>, las habilidades con @ por ahora solo funcionan con Office en inglés. Para análisis entre varios archivos, el agente Analyst, del que hablo enseguida, escribe y ejecuta Python y te muestra el código; esa transparencia es la que te permite auditarlo.</p>

<h2>Los agentes: quién es quién</h2>
{{img:agentes}}
<ul>
<li><strong>Analyst</strong> planea el análisis, escribe y ejecuta Python, limpia datos y entrega gráficos y comentarios a partir de archivos que adjuntas (<a href="https://support.microsoft.com/topic/ff505b9c-a06c-4be9-b855-69d89b1d25d2" target="_blank" rel="noopener">guía de Microsoft</a>). Prompt de ejemplo: «Adjunto Ventas_2025.xlsx e Inventario.csv. Compara la rotación por categoría y trimestre, identifica los diez productos con más días de inventario y muéstrame el código que usaste».</li>
<li><strong>Researcher</strong> hace investigación de varios pasos con fuentes web y de trabajo. Ambos se lanzaron para clientes empresariales en junio de 2025, entonces con <a href="https://www.microsoft.com/en-us/microsoft-365/blog/?p=276953" target="_blank" rel="noopener">25 consultas combinadas al mes</a>; revisa los límites vigentes de tu plan.</li>
<li><strong>Agente de Excel</strong> en la app de Microsoft 365 Copilot crea un libro completo desde el chat; según el <a href="https://support.microsoft.com/topic/76691f5e-bb19-4029-a34d-33a00e0a0c4f" target="_blank" rel="noopener">soporte</a>, también lo pueden usar personas sin licencia de Copilot, con información de la web y archivos que referencien.</li>
<li><strong>Agent Builder y Copilot Studio</strong> sirven para crear agentes propios. Microsoft Learn lo resume así: <a href="https://learn.microsoft.com/en-us/microsoft-365-copilot/extensibility/copilot-studio-experience" target="_blank" rel="noopener">Agent Builder</a> para agentes sencillos, sin código, para ti o tu equipo; Copilot Studio para flujos de varios pasos, conectores y publicación amplia. Sin licencia de Copilot se usan con Copilot Credits o pago por uso, y Agent Builder es gratuito si el agente solo usa conocimiento de la web.</li>
<li><strong>Copilot Cowork</strong>, disponible desde junio de 2026, ejecuta tareas largas entre aplicaciones con <a href="https://techcommunity.microsoft.com/blog/microsoft-copilot-blog/what%E2%80%99s-new-in-microsoft-365-copilot--june-2026/4529572" target="_blank" rel="noopener">facturación por uso</a>.</li>
</ul>
<p>Estas son las instrucciones de un agente que configuré con Agent Builder para un comité de evaluación; cópialas y adáptalas:</p>
<pre><code>Nombre: Asistente del comité de evaluación
Conocimiento: carpeta "Comité 2026" (SIEE, actas y libros de notas con códigos)

Instrucciones:
- Responde solo con base en los archivos de la carpeta. Si un dato no
  está, dilo; nunca lo estimes.
- Nunca muestres nombres, documentos de identidad ni datos de salud:
  usa siempre el código del estudiante.
- Cada cifra debe indicar archivo, hoja y rango de origen.
- Propón acciones pedagógicas concretas y marca cuáles requieren
  decisión del comité.
- Tono respetuoso y sin juicios sobre las familias.

Iniciadores:
- "Resume los casos en Bajo del grado 9 en el periodo 3"
- "¿Qué dice el SIEE sobre las actividades de recuperación?"</code></pre>

<h2>Copilot Pages: del análisis al documento del equipo</h2>
<p><a href="https://support.microsoft.com/en-us/microsoft-365-copilot/get-started-with-microsoft-365-copilot-pages" target="_blank" rel="noopener">Copilot Pages</a> convierte una respuesta de Copilot en una página persistente que editas, compartes y refinas con tu equipo y con Copilot. Se crea con <em>Editar en Pages</em> en el menú de una respuesta, o desde el botón + del chat, en <em>Más</em>, con la opción de redactar una página. Con cuenta de trabajo, la pueden usar quienes tienen almacenamiento de OneDrive o SharePoint, aun sin licencia de Copilot; con cuenta personal, los suscriptores de Personal, Familia, Premium o Pro. Admite gráficos interactivos, y el equipo puede coeditar sin entrar a tu chat. Una advertencia que hace <a href="https://support.microsoft.com/en-us/microsoft-365-copilot/how-microsoft-365-copilot-pages-works" target="_blank" rel="noopener">la propia Microsoft</a>: si varias personas editan a la vez, la respuesta de Copilot puede no reflejar todos los cambios hasta que actualices la página.</p>
{{img:pages}}
<p>Así lo uso con un análisis de Excel: Analyst o Copilot en Excel producen el resumen; lo paso a Pages; el coordinador agrega el plan de tutorías, un docente verifica los totales con la tabla dinámica y deja su comentario; y desde junio de 2026 puedo <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-june-2026/4523402" target="_blank" rel="noopener">adjuntar páginas de Loop</a> como contexto en Copilot en Excel para la siguiente pregunta. La página se convierte en el acta viva de la decisión, no en un correo más que nadie encuentra.</p>
<pre><code>Prompt dentro de la página:
Convierte estos hallazgos en una tabla con columnas Curso, Hallazgo,
Cifra, Fuente (archivo y rango), Acción y Responsable. Deja vacía la
columna Responsable para que el comité la complete.</code></pre>

<h2>Licencias: qué necesitas en cada caso</h2>
<table>
<thead><tr><th>Tu situación</th><th>Copilot dentro de Excel</th><th>Agentes y Pages</th></tr></thead>
<tbody>
<tr><td>Microsoft 365 Personal o Familia</td><td>Sí, con créditos de IA mensuales y solo para el titular</td><td>Pages sí</td></tr>
<tr><td>Microsoft 365 Premium (USD 19,99 al mes en EE. UU.)</td><td>Sí, con los límites más altos</td><td>Researcher, Analyst y Pages</td></tr>
<tr><td>Empresa con licencia de Microsoft 365 Copilot</td><td>Completo: modo agente, modelos, historial de chats, Work IQ</td><td>Todos, más Agent Builder y Copilot Studio</td></tr>
<tr><td>Empresa sin licencia, más de 2.000 puestos</td><td>No, desde el 15 de abril de 2026</td><td>Copilot Chat en la web, agentes de Word, Excel y PowerPoint, Pages</td></tr>
<tr><td>Empresa sin licencia, hasta 2.000 puestos</td><td>Copilot Chat con acceso estándar, sujeto a capacidad</td><td>Igual que la fila anterior</td></tr>
</tbody>
</table>
<p>Fuentes: <a href="https://support.microsoft.com/office/frequently-asked-questions-about-copilot-in-microsoft-365-subscriptions-bda0d6e8-346d-41ce-ab1e-f6af6229c462" target="_blank" rel="noopener">preguntas frecuentes de Copilot para hogares</a>, <a href="https://www.microsoft.com/en-us/copilot/blog/2025/10/01/meet-microsoft-365-premium-your-ai-and-productivity-powerhouse/" target="_blank" rel="noopener">anuncio de Microsoft 365 Premium</a> y el cambio para usuarios sin licencia anunciado en los mensajes MC1253858 y MC1253863, resumido por <a href="https://kurtsh.com/2026/04/05/info-copilot-chat-behavior-changes-for-microsoft-365-users-coming-april-15-2026/" target="_blank" rel="noopener">Kurt Shintaku</a>. En Familia, aunque el plan cubre a seis personas, las funciones de IA son solo del titular. Para Analyst y Researcher en empresas se necesita la licencia de Microsoft 365 Copilot. Verás también un cambio de nombre: la documentación de Microsoft Learn ya llama <em>Microsoft Copilot</em> a Microsoft 365 Copilot y <em>Microsoft Copilot Chat</em> a Copilot Chat; durante la transición conviven ambos nombres.</p>

<h2>Privacidad y gobierno: lo que todo directivo debe saber</h2>
<ul>
<li><strong>Protección de datos empresariales.</strong> Con cuenta de trabajo, los prompts y respuestas quedan bajo el anexo de protección de datos de Microsoft, y <a href="https://learn.microsoft.com/en-us/copilot/microsoft-365/enterprise-data-protection" target="_blank" rel="noopener">no se usan para entrenar modelos fundacionales</a>. Copilot respeta permisos, etiquetas de confidencialidad, retención y auditoría.</li>
<li><strong>Etiquetas de confidencialidad.</strong> Si un archivo cifrado te da permiso de ver pero no de copiar (el derecho EXTRACT), <a href="https://learn.microsoft.com/en-us/purview/ai-m365-copilot-considerations" target="_blank" rel="noopener">no podrás usar Copilot con él</a>. Es una forma sencilla de proteger nóminas o historias clínicas.</li>
<li><strong>Modelos de Anthropic.</strong> En cuentas empresariales, el administrador debe <a href="https://support.microsoft.com/topic/b2c3b3ec-154b-484b-84d0-914a80df395a" target="_blank" rel="noopener">habilitarlos</a>; Anthropic actúa como subencargado, y sus modelos están excluidos por ahora del límite de datos de la Unión Europea.</li>
<li><strong>Búsquedas web.</strong> Las consultas que Copilot envía a Bing salen sin identificadores de usuario ni de organización, pero se rigen por términos distintos de los de Microsoft 365.</li>
</ul>

<h2>Limitaciones y cómo verificar</h2>
<p>Copilot es muy bueno escribiendo fórmulas y armando tablas, pero puede inventar una cifra en un resumen con total seguridad. Microsoft lo dice en su <a href="https://support.microsoft.com/topic/cecc7821-39c1-4e12-8bd6-4d4348370585" target="_blank" rel="noopener">propia documentación</a>: revisa, edita y verifica todo lo que Copilot crea. Mi lista mínima antes de firmar:</p>
<ol>
<li>Exige fórmulas y no valores pegados, y abre al menos tres para leerlas.</li>
<li>Pon una celda de control que compare cada resumen con la suma de su origen y debe dar 0.</li>
<li>Pasa el cursor por las citas numeradas y comprueba que señalan las filas correctas.</li>
<li>Lee una muestra aleatoria de lo que Copilot clasificó.</li>
<li>Usa el modo plan para tareas grandes y no apruebes un plan que no entiendas.</li>
<li>Después de varias ediciones, pregunta al historial qué cambió.</li>
<li>Si el resultado va a otra persona con Excel 2019 o 2021, revisa que no use funciones que su versión no tiene.</li>
</ol>

<h2>Sin Copilot también se puede: alternativas gratuitas</h2>
<p>Si en tu colegio o empresa no hay licencia, ChatGPT, Gemini o Claude escriben y explican fórmulas para cualquier versión de Excel; la clave es describir la estructura, nunca pegar datos personales. Lo expliqué con detalle en <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial: ejemplos prácticos</a>, donde también regalo el módulo <strong>ExcelConIA</strong>: la macro PerfilarDatos diagnostica tu tabla, GenerarPromptIA arma un prompt sin datos personales y la función <code>=IA_CLASIFICAR(B2; $H$2:$H$6)</code> clasifica desde una celda con tu propia clave gratuita de Google Gemini. Es, en la práctica, una forma de recuperar la comodidad de la función retirada en cualquier Excel de Windows. Puedes <a href="/descargas/excel-con-ia/excel-con-ia.zip">descargar el paquete completo gratis</a>, y si solo necesitas funciones puntuales, están las herramientas gratuitas de <a href="/herramientas/numero-a-letras/">número a letras</a> y <a href="/herramientas/generador-qr/">códigos QR</a>.</p>

<p class="notice"><strong>Para llevarlo a tu trabajo.</strong> La IA te ayuda a analizar; las tareas que se repiten cada semana merecen una plantilla que siempre haga lo mismo. En la sección de <a href="/excel/">Excel y automatización</a> encuentras <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">envío masivo de correos con adjuntos</a>, <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">combinación de correspondencia a PDF</a>, el <a href="/producto/generador-de-codigos-qr-masivos/">generador de códigos QR masivos</a> y la <a href="/producto/factura-con-envio-por-correo-al-cliente/">factura con envío por correo</a>. Si eres docente, empieza por el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> y el <a href="/herramientas/generador-de-examenes/">generador de exámenes</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Puedo seguir escribiendo en lenguaje natural «dentro de la celda»?</h3>
<p>No con <code>=COPILOT()</code>, que fue retirada. Hoy lo haces desde el panel de Copilot: el modo agente escribe en la hoja columnas, fórmulas y tablas dinámicas que quedan como datos auditables. Si necesitas una función de celda, una alternativa es la función <code>=IA()</code> del módulo gratuito ExcelConIA, con tu propia clave.</p>
<h3>¿Copilot reemplaza las fórmulas?</h3>
<p>No. Copilot las escribe por ti, pero el resultado confiable sigue siendo una fórmula que alguien puede leer. Por eso pido siempre fórmulas en lugar de valores y una celda de control.</p>
<h3>¿Qué modelo elijo en el selector?</h3>
<p>Empieza con Auto. Si una tarea compleja sale mal, repítela con otro modelo y compara: esa comparación es una forma barata de detectar errores.</p>

<h2>Para pensar</h2>
<p>Durante décadas, el momento más importante del trabajo con datos fue ese silencio incómodo en el que alguien miraba una cifra y decía «esto no puede ser». Hoy basta un clic en «Aprobar plan» para que un agente clasifique, resuma y proponga a quién remitir a recuperación o a qué proveedor dejar de comprarle. <strong>Si ese clic se vuelve rutina, ¿quién responde cuando el agente se equivoca: la persona que aprobó sin leer, la institución que pidió hacerlo más rápido o la empresa que diseñó el modelo? ¿Y estamos dispuestos a medir la productividad por cuántos planes aprobamos o por cuántas veces nos detuvimos a dudar?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:flujo}}' => $img('copilot-excel-flujo', 580, 'Diagrama de cinco pasos de la pregunta al resultado con Copilot en Excel: preguntar (Copilot Chat, skills con @, hoja .Rules), planear (modo plan, modelo Auto), actuar (modo agente, AGRUPARPOR, =PY), verificar (SUMA de control, historial de cambios) y compartir (Copilot Pages, Teams y Outlook), con quién hace cada paso', 'Copilot hace el trabajo del medio; la pregunta y la verificación siguen siendo tuyas.'),
    '{{img:agentes}}' => $img('copilot-excel-agentes', 640, 'Mapa de agentes en cuatro grupos: dentro de Excel (Copilot Chat, modo agente y modo plan, skills con @), agentes de Microsoft en la app de Microsoft 365 Copilot (Analyst, Researcher, agente de Excel), agentes propios (Agent Builder y Copilot Studio) y tareas largas (Copilot Cowork y automatizaciones), con la licencia que requiere cada grupo', 'Qué agente usar para cada trabajo con datos y qué licencia pide cada uno.'),
    '{{img:pages}}' => $img('copilot-excel-pages', 600, 'Flujo de Copilot Pages en cuatro pasos (analiza, editar en Pages, colabora, decide y vuelve) y una página de ejemplo titulada Comité de evaluación periodo 3, con hallazgos por curso, un gráfico de estudiantes en Bajo por curso, tres coautores y el comentario de un docente que verificó los totales con la tabla dinámica', 'Una página de Copilot convierte el análisis de Excel en el acta viva de una decisión del equipo.'),
]);

return [
    'slug' => 'copilot-agentes-excel-lenguaje-natural-copilot-pages',
    'title' => 'Copilot y agentes en Excel: lenguaje natural, clasificación, resúmenes y Copilot Pages',
    'excerpt' => 'Qué hay hoy en Excel con Copilot (modo agente, modo plan, elección de modelo), qué pasó con la función =COPILOT(), cómo clasificar y resumir con prompts reales, qué agentes existen, para qué sirve Copilot Pages, qué licencia necesitas y cómo verificar, con fórmulas y código para pymes, finanzas, talento humano, docentes y analistas.',
    'seo_title' => 'Copilot y agentes en Excel: guía práctica 2026',
    'seo_description' => 'Copilot en Excel hoy: modo agente, fin de =COPILOT(), agentes Analyst y Researcher, Copilot Pages, licencias y prompts con fórmulas para pymes y docentes.',
    'focus_keyword' => 'Copilot en Excel',
    'cover' => '/assets/img/articulos/copilot-excel/copilot-excel-portada',
    'cover_alt' => 'Portada Copilot y agentes en Excel: hoja Comentarios.xlsx con columnas Tema y Sentimiento, panel de Copilot en modo agente con un plan de tres pasos y tarjeta con Analyst, Researcher y Copilot Pages',
    'published_at' => '2026-10-08 15:00:00',
    'content_html' => $html,
];
