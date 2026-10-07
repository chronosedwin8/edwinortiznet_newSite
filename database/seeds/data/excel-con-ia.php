<?php

declare(strict_types=1);

// Artículo práctico: Excel con inteligencia artificial (Copilot, Python en Excel, prompts, verificación, privacidad)
// con ejemplos para pymes, profesionales, docentes, directivos y analistas, y descarga gratuita de macros.
// El texto va en nowdoc para que las fórmulas ($, <, &) no se interpreten; los bloques <pre><code> se escapan
// automáticamente y las figuras y videos se insertan con marcadores {{img:…}} y {{yt:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/excel-ia/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$yt = static fn (string $id, string $alt): string => '<figure class="lite-yt" data-yt="' . $id . '"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=' . $id . '" data-yt="' . $id . '">'
    . '<img src="https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg" alt="' . $alt . '" width="480" height="360"><span class="lite-yt__play"></span></a></figure>';
$code = static fn (string $html): string => (string) preg_replace_callback(
    '#<pre><code>(.*?)</code></pre>#s',
    static fn (array $m): string => '<pre><code>' . htmlspecialchars($m[1], ENT_NOQUOTES, 'UTF-8') . '</code></pre>',
    $html
);

$html = <<<'HTML'
<p>Hay una escena que se repite en casi todas las oficinas, rectorías y salas de profesores que conozco: alguien abre un Excel enorme, suspira y dice «esto lo debería hacer la inteligencia artificial». Y tiene razón a medias. La IA ya escribe en segundos fórmulas que antes costaban una tarde, explica un <em>#¡VALOR!</em> que nadie entendía y clasifica mil comentarios en minutos. Pero también inventa funciones que no existen, suma la columna equivocada con total seguridad o recibe, sin que nadie lo note, los datos personales de quinientos estudiantes.</p>
<p>Llevo más de veinte años enseñando matemáticas y tecnología y construyendo plantillas de Excel para empresas y colegios. Lo que he aprendido usando IA con hojas de cálculo cabe en una frase: <strong>la IA hace menos necesario memorizar fórmulas, pero hace más necesario entender tus datos</strong>. Quien sabe qué pregunta hacer, cómo está organizada su tabla y cómo comprobar una respuesta, obtiene resultados excelentes. Quien no, obtiene errores más rápido.</p>
<p>Esta guía es práctica de principio a fin: herramientas actuales, una receta de prompt, fórmulas reales para pymes, profesionales, docentes y directivos, un nivel experto con Python y, al final, un regalo para que lo pruebes con tus propios archivos.</p>

{{img:flujo}}

<h2>Antes de pedirle nada a la IA: un libro que se deje ayudar</h2>
<p>Ningún asistente, por bueno que sea, entiende un libro con celdas combinadas, encabezados en tres filas, totales mezclados con datos y una columna que dice «ver nota». Antes de abrir cualquier chat, revisa estas cinco reglas; hoy valen el doble, porque la IA lee tu archivo como lo leería un compañero nuevo.</p>
<ol>
<li><strong>Una tabla, una fila por registro.</strong> Una venta, un estudiante en un área o un movimiento bancario por fila. Convierte el rango en tabla con Ctrl+T y ponle un nombre claro, como <em>Ventas</em> o <em>Notas</em>.</li>
<li><strong>Encabezados únicos y sin celdas combinadas.</strong> «Total» y «Fecha» le dicen a la IA qué hay en cada columna; «Columna1» no le dice nada.</li>
<li><strong>Separa entradas, cálculos y resultados.</strong> Las tasas, metas y escalas van en celdas o tablas propias, no escondidas dentro de una fórmula como <code>*0,19</code>. Si el IVA cambia, cambias una celda, no doscientas.</li>
<li><strong>Un tipo de dato por columna.</strong> Si en la columna de fechas hay textos como «pendiente», cualquier análisis, humano o artificial, se rompe.</li>
<li><strong>Deja contexto escrito.</strong> Una hoja «Léeme» con el origen de los datos, la fecha de corte y el significado de cada código.</li>
</ol>

<h2>El mapa: qué IA hay hoy para Excel y qué necesitas para usarla</h2>
<p>El ecosistema cambia cada pocos meses, así que te comparto lo que verifiqué en la documentación oficial de Microsoft y de Google a comienzos de octubre de 2026.</p>
<table>
<thead><tr><th>Herramienta</th><th>Qué hace</th><th>Qué necesitas</th></tr></thead>
<tbody>
<tr><td>Copilot en Excel (panel y modo agente)</td><td>Crea fórmulas, tablas dinámicas y gráficos, analiza datos y, en modo agente, ejecuta tareas de varios pasos dentro del libro</td><td>Hogares: Microsoft 365 Personal, Familia o Premium. Empresas: licencia de Microsoft 365 Copilot</td></tr>
<tr><td>Función <code>=COPILOT()</code></td><td>Era una función que llamaba a la IA desde una celda</td><td>Retirada el 14 de septiembre de 2026; las celdas que la usan devuelven <em>#¿NOMBRE?</em> al recalcular</td></tr>
<tr><td>Python en Excel (<code>=PY</code>)</td><td>Ejecuta pandas, gráficos y estadística dentro de una celda, en la nube de Microsoft</td><td>Microsoft 365 empresarial (Windows, web y Mac); en vista previa para Personal y Familia</td></tr>
<tr><td>Analizar datos</td><td>Propone gráficos, tendencias y resúmenes automáticos de una tabla</td><td>Excel de Microsoft 365, botón en la pestaña Inicio</td></tr>
<tr><td>ChatGPT, Gemini o Claude</td><td>Escriben y explican fórmulas, macros, consultas de Power Query y código Python</td><td>Cualquier versión de Excel; cuidado con lo que pegas</td></tr>
<tr><td>Funciones modernas</td><td>AGRUPARPOR, PIVOTARPOR, LET, LAMBDA y las funciones REGEX resumen y limpian sin IA</td><td>Excel de Microsoft 365</td></tr>
</tbody>
</table>
<p>Tres precisiones. El <strong>modo agente</strong> de Copilot está disponible de forma general en Excel para la web desde diciembre de 2025 y en Windows y Mac desde enero de 2026, con selector de modelos de OpenAI y Anthropic. Desde el 15 de abril de 2026, en organizaciones con más de 2.000 puestos de Microsoft 365, quien no tiene licencia de Microsoft 365 Copilot ya no ve Copilot Chat dentro de Word, Excel y PowerPoint; en las más pequeñas sigue con acceso estándar, que puede limitarse en horas pico. Y la función <code>=COPILOT()</code> nunca salió de la beta: si un libro depende de ella, ya no recalcula.</p>
<p>¿Y si en tu colegio o empresa tienen Excel 2019 o 2021 sin Copilot? No pasa nada: un chat externo bien usado, más las fórmulas clásicas, te lleva muy lejos. Casi todos los ejemplos de esta guía traen una alternativa para versiones anteriores.</p>

<h2>La receta de prompt para Excel</h2>
<p>La mayoría de las respuestas malas vienen de preguntas pobres. «Hazme una fórmula para sumar las ventas» obliga a la IA a adivinar seis cosas. Esta es la receta que uso, con seis ingredientes:</p>
{{img:receta}}
<pre><code>Actúa como experto en Excel. Uso Microsoft 365 en español (separador ;).

DATOS: tabla llamada Ventas, unas 800 filas. Columnas: Fecha (fecha),
Ciudad (texto), Vendedor (texto), Producto (texto), Categoría (texto),
Unidades (entero), Precio unitario (pesos), Total (pesos), Canal (texto).
Ejemplo ficticio: 15/01/2026 | Montería | Vendedor 3 | Café molido 500 g |
Alimentos | 3 | 21900 | 65700 | WhatsApp

OBJETIVO: un resumen del valor vendido por ciudad (filas) y mes
(columnas), con totales, que se actualice solo cuando agregue ventas.

RESTRICCIONES: nombres de funciones en español; sin macros; sin columnas
auxiliares. Si la función ideal no existe en Excel 2021, dame también
una alternativa compatible.

FORMATO: la fórmula en un bloque, explicación parte por parte y tres
casos de prueba con el resultado que debería obtener.</code></pre>
<p>Fíjate en lo que no lleva: ni una fila real. La IA no necesita ver los datos de tus clientes para escribir la fórmula; necesita la estructura, el objetivo y las reglas. Otros prompts que uso a diario:</p>
<ul>
<li><strong>Para explicar un error:</strong> «Esta fórmula devuelve #N/D en algunas filas: [fórmula]. El Código es texto en Clientes y número en Pedidos. Dame la causa probable y dos soluciones».</li>
<li><strong>Para auditar un modelo:</strong> «Te describo las hojas y fórmulas clave de mi presupuesto. Busca constantes dentro de fórmulas, referencias mal fijadas, rangos que no crecen y referencias circulares. Dame una tabla con hallazgo, celda y riesgo».</li>
<li><strong>Para aprender, no solo copiar:</strong> «Explícame esta fórmula como si fuera tu estudiante de once y luego dame un ejercicio parecido para practicar».</li>
</ul>

<h2>Ejemplos prácticos para pymes y profesionales</h2>
<h3>Ventas por ciudad y mes, con y sin funciones nuevas</h3>
<p>Este es el resumen que más me piden los comerciantes. En Microsoft 365, una sola fórmula reemplaza la tabla dinámica y se actualiza sola:</p>
<pre><code>=PIVOTARPOR(Ventas[Ciudad]; TEXTO(Ventas[Fecha]; "aaaa-mm"); Ventas[Total]; SUMA)</code></pre>
<p>PIVOTARPOR (PIVOTBY en inglés) recibe lo que va en filas, lo que va en columnas, los valores y la función. Si solo necesitas una lista por ciudad, AGRUPARPOR (GROUPBY) es aún más corta, y puedes pedir el porcentaje de cada ciudad sobre el total:</p>
<pre><code>=AGRUPARPOR(Ventas[Ciudad]; Ventas[Total]; SUMA)
=AGRUPARPOR(Ventas[Ciudad]; Ventas[Total]; PORCENTAJEDE)</code></pre>
<p>¿Excel 2019 o 2021? Escribe las ciudades en A2:A6 y el primer día de cada mes en B1:M1, y usa SUMAR.SI.CONJUNTO (SUMIFS):</p>
<pre><code>=SUMAR.SI.CONJUNTO(Ventas[Total]; Ventas[Ciudad]; $A2;
    Ventas[Fecha]; ">="&B$1; Ventas[Fecha]; "<="&FIN.MES(B$1; 0))</code></pre>
<p>Un detalle: «aaaa-mm» es el código de Excel en español; en inglés es «yyyy-mm». La IA lo olvida si no le dices tu idioma.</p>
<p>Si prefieres las tablas dinámicas de toda la vida, que siguen siendo la herramienta más rápida para explorar, en este video de mi canal te muestro cómo dominarlas paso a paso:</p>
{{yt:HjR1u-3KGik|Video de Edwin Ortiz: el secreto para dominar las tablas dinámicas en Excel}}

<h3>Pronóstico de ventas sin estadística avanzada</h3>
<p>Con 24 o más meses de historia, PRONOSTICO.ETS (FORECAST.ETS) proyecta el siguiente mes considerando la tendencia y la temporada. Si las fechas están en A2:A25, las ventas en B2:B25 y el mes que quieres proyectar en A26:</p>
<pre><code>=PRONOSTICO.ETS(A26; $B$2:$B$25; $A$2:$A$25; 12)
=PRONOSTICO.ETS.CONFINT(A26; $B$2:$B$25; $A$2:$A$25; 0,95; 12)</code></pre>
<p>La segunda da el margen de error con un 95 % de confianza. Muéstralo siempre: un pronóstico sin margen es una promesa. Las fechas deben tener un paso constante, como el primer día de cada mes, y la función no está en Excel para la web.</p>

<h3>Inventario: cuándo volver a pedir</h3>
<p>En una tabla de inventario con las columnas Existencia, Vendidas90 (unidades de los últimos 90 días), DiasEntrega y StockSeguridad, LET (la misma en inglés) permite escribir el cálculo como lo diría un tendero:</p>
<pre><code>=LET(demanda; [@Vendidas90] / 90;
     reorden; demanda * [@DiasEntrega] + [@StockSeguridad];
     SI([@Existencia] <= reorden; "Pedir"; "OK"))</code></pre>
<p>Cambia a mano los datos de una fila para ver si la alerta aparece cuando debe. Si además manejas activos fijos, mi <a href="/producto/generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras/">generador de etiquetas para inventario con QR y códigos de barras</a> imprime las etiquetas desde la misma lista.</p>

<h3>Finanzas y contabilidad: modelos que se puedan auditar</h3>
<p>Las entidades financieras en Colombia suelen informar la tasa efectiva anual, pero la cuota se calcula con la tasa mensual. Con la tasa en B1, el plazo en meses en B2 y el monto en B3:</p>
<pre><code>Tasa mensual (B4):  =(1 + B1)^(1/12) - 1
Cuota fija (B5):    =PAGO(B4; B2; -B3)
Total intereses:    =B5 * B2 - B3</code></pre>
<p>Entradas, cálculos y resultado van en colores distintos; así cualquiera, incluida la IA, entiende el modelo. En este video de mi canal te explico la función PAGO con un caso completo:</p>
{{yt:wtLK7qD_hOg|Video de Edwin Ortiz: cómo calcular la cuota de un préstamo en Excel con la función PAGO}}
<p>Para conciliar, la IA propone muy bien fórmulas con tolerancia. Esta busca en el extracto un movimiento con hasta 100 pesos de diferencia y tres días de distancia:</p>
<pre><code>=FILTRAR(Banco[Referencia];
    (ABS(Banco[Valor] - [@Valor]) <= 100) * (ABS(Banco[Fecha] - [@Fecha]) <= 3);
    "Sin coincidencia")</code></pre>
<p>Ojo: si dos movimientos cumplen la condición, devuelve los dos. ¿La IA te lo advirtió? Una fórmula se prueba con los casos difíciles, no con los fáciles.</p>

<h3>Talento humano: limpiar antes de analizar</h3>
<p>Las bases de personal llegan con espacios dobles, nombres en mayúsculas y cédulas con puntos. Tres fórmulas resuelven el 80 % del problema:</p>
<pre><code>Nombre limpio:   =NOMPROPIO(ESPACIOS(LIMPIAR(A2)))
Solo dígitos:    =REGEXREEMPLAZAR(B2; "[^0-9]"; "")
Celular válido:  =REGEXEXTRACCION(C2; "3\d{9}")</code></pre>
<p>ESPACIOS (TRIM) quita los espacios sobrantes y NOMPROPIO (PROPER) corrige las mayúsculas. Las funciones REGEX de Microsoft 365, REGEXREEMPLAZAR (REGEXREPLACE) y REGEXEXTRACCION (REGEXEXTRACT), trabajan con patrones: la primera deja solo los números y la segunda extrae un celular de diez dígitos que empiece por 3. Si la limpieza se repite cada mes, hazla en <strong>Power Query</strong> (Datos &gt; Obtener datos), que guarda los pasos y los repite con un clic; la IA escribe muy bien esos pasos si le describes las columnas. Y una regla de oro para esta área: nombres, cédulas, salarios, incapacidades y diagnósticos nunca van a un chat.</p>

<h3>Ventas y servicio al cliente: clasificar comentarios</h3>
<p>Cientos de comentarios de una encuesta se pueden clasificar de dos maneras. La determinista, con palabras clave, es gratis, instantánea y siempre da el mismo resultado:</p>
<pre><code>=SI.CONJUNTO(
    REGEXPRUEBA(A2; "demor|tarde|lleg"; 1); "Entrega";
    REGEXPRUEBA(A2; "precio|caro|costos"; 1); "Precio";
    REGEXPRUEBA(A2; "atenci|amable|grosero"; 1); "Atención";
    VERDADERO; "Otro")</code></pre>
<p>REGEXPRUEBA (REGEXTEST) devuelve VERDADERO si encuentra el patrón; el 1 final ignora mayúsculas. Funciona hasta que alguien escribe «nunca más les compro, una vergüenza»: ninguna palabra clave, y es el comentario que más importa. Ahí un modelo de lenguaje vale la pena, porque entiende la intención; más adelante verás cómo usarlo con la descarga gratuita o con Python.</p>

<h2>Ejemplos para docentes y directivos docentes</h2>
<h3>Niveles de desempeño del Decreto 1290</h3>
<p>El Decreto 1290 de 2009 define la escala nacional con cuatro niveles (Superior, Alto, Básico y Bajo), y cada institución fija en su Sistema Institucional de Evaluación (SIEE) los rangos numéricos equivalentes. Por eso no escribo los cortes dentro de la fórmula: los pongo en una tabla llamada Escala, con las columnas Desde y Desempeño (por ejemplo 1,0 Bajo; 3,0 Básico; 4,0 Alto; 4,6 Superior) y uso BUSCARX (XLOOKUP) con coincidencia aproximada hacia abajo:</p>
<pre><code>=BUSCARX([@Nota]; Escala[Desde]; Escala[Desempeño]; "Sin nota"; -1)</code></pre>
<p>Si el consejo académico cambia los rangos, cambias la tabla Escala y todo el libro se actualiza. La IA escribe la fórmula; tú sabes que los rangos son institucionales.</p>
<h3>Asistencia</h3>
<p>Con una fila por estudiante y una columna por día, marcando A (asistió) o F (falta), el porcentaje de asistencia y la alerta son dos fórmulas:</p>
<pre><code>% asistencia:  =CONTAR.SI(C2:Z2; "A") / CONTARA(C2:Z2)
Alerta:        =SI(AA2 < 0,8; "Revisar"; "")</code></pre>
<p>En este video de mi canal te muestro, paso a paso, cómo construir en Excel una lista de asistencia para estudiantes o trabajadores:</p>
{{yt:JncUBa3uihY|Video de Edwin Ortiz: lista de asistencia en Excel para trabajadores o estudiantes}}
<p>Y si no quieres construirla, la plantilla de <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">listado de asistencia laboral o académica</a> ya está lista para usar.</p>
<h3>Para directivos: el consolidado que se lleva al comité</h3>
<p>Coordinadores y rectores necesitan el panorama sin abrir cuarenta planillas. Con todas las notas en una tabla Notas (Código estudiante, Grado, Curso, Área, Periodo, Nota, Inasistencias), esta fórmula cuenta cuántos estudiantes quedaron en Bajo por curso y área en el periodo 2:</p>
<pre><code>=PIVOTARPOR(Notas[Curso]; Notas[Área]; Notas[Nota];
    LAMBDA(x; SUMA(--(x < 3))); ; ; ; ; ;
    (Notas[Periodo] = 2) * (Notas[Nota] <> "") = 1)</code></pre>
<p>Y esta lista a los estudiantes en riesgo, entendidos como quienes tienen dos o más áreas en Bajo en ese periodo:</p>
<pre><code>=LET(t; AGRUPARPOR(APILARH(Notas[Curso]; Notas[Código estudiante]); Notas[Nota];
        LAMBDA(x; SUMA(--(x < 3))); 0; 0; ;
        (Notas[Periodo] = 2) * (Notas[Nota] <> "") = 1);
     FILTRAR(t; ELEGIRCOLS(t; 3) >= 2; "Sin estudiantes en riesgo"))</code></pre>
<p>¿Por qué el filtro <code>Notas[Nota] &lt;&gt; ""</code>? Porque una nota pendiente, una celda vacía, se compara como cero y el estudiante aparecería en Bajo sin serlo. La IA no ve ese error si no le cuentas que hay notas pendientes; la macro de perfilado de la descarga gratuita sí. En Excel 2019 o 2021 usa una columna auxiliar con CONTAR.SI.CONJUNTO (COUNTIFS): <code>=CONTAR.SI.CONJUNTO(Notas[Código estudiante]; [@[Código estudiante]]; Notas[Nota]; "&lt;3"; Notas[Periodo]; 2)</code>. Crúzalo con las inasistencias y tendrás una comisión de evaluación y promoción con datos, no con impresiones. Eso sí: un listado de riesgo es una alerta para conversar con el estudiante y su familia, no una etiqueta.</p>
<p>Para la parte del trabajo docente que no vive en Excel tengo dos herramientas: el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>, con recetas de prompts probadas por materia (los de Matemáticas y Tecnología e Informática encajan muy bien con esta guía; te cuento cómo los construí en <a href="/kit-de-ia-para-docentes-prompts-probados-curriculo-colombiano/">este artículo</a>), y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>, con versiones, hoja de respuestas y solucionario, que puedes <a href="/examenes/demo/">probar gratis en el simulador</a>.</p>

<h2>Para analistas de datos: tus propias funciones con LAMBDA</h2>
<p>LAMBDA (igual en inglés) te deja crear funciones con nombre sin programar macros. En el Administrador de nombres (Fórmulas &gt; Administrador de nombres) crea el nombre NIVEL1290 con esta definición:</p>
<pre><code>=LAMBDA(nota; BUSCARX(nota; Escala[Desde]; Escala[Desempeño]; "Sin nota"; -1))</code></pre>
<p>Desde ese momento, <code>=NIVEL1290(B2)</code> funciona en todo el libro como una función más. Escribes la regla una vez, la pruebas una vez y la reutilizas cien. La IA es buena compañera para escribir LAMBDA complejas, siempre que le des casos de prueba.</p>

<h2>Nivel experto: Excel y Python</h2>
<p>Detectar atípicos con un criterio estadístico, ajustar una regresión o procesar diez mil textos con un modelo de lenguaje es difícil con fórmulas. Para eso existe Python, y hoy tienes dos caminos.</p>
{{img:python}}
<h3>Camino 1: Python en Excel</h3>
<p>Escribes <code>=PY</code> en una celda, pulsas Tab y la celda se vuelve un editor de Python; confirmas con Ctrl+Enter. El código corre en la nube de Microsoft con una distribución de Anaconda que ya trae pandas, NumPy, Matplotlib, seaborn y statsmodels; no puede leer archivos de tu computador ni conectarse a internet, y lee el libro con <code>xl()</code>. Selecciona el rango con el mouse y deja que Excel escriba la referencia.</p>
<p>Ventas por ciudad y mes, al estilo pandas:</p>
<pre><code>df = xl("Ventas[#Todo]", headers=True)
df["Mes"] = df["Fecha"].dt.to_period("M").astype(str)
df.pivot_table(index="Ciudad", columns="Mes", values="Total",
               aggfunc="sum", fill_value=0)</code></pre>
<p>Ventas atípicas con el criterio del rango intercuartílico:</p>
<pre><code>df = xl("Ventas[#Todo]", headers=True)
q1, q3 = df["Total"].quantile([0.25, 0.75])
iqr = q3 - q1
atipicas = df[(df["Total"] < q1 - 1.5 * iqr) | (df["Total"] > q3 + 1.5 * iqr)]
atipicas.sort_values("Total", ascending=False)</code></pre>
<p>Y para un directivo que quiere saber cuánto pesan las inasistencias en el promedio, una regresión simple. Fíjate en las dos líneas de limpieza: convierten las notas escritas como texto («3,5») y descartan las imposibles (un 45 que debía ser 4,5):</p>
<pre><code># Celda 1: promedio e inasistencias por estudiante, y el modelo
import statsmodels.formula.api as smf
notas = xl("Notas[#Todo]", headers=True)
notas["Nota"] = pd.to_numeric(notas["Nota"].astype(str).str.replace(",", "."), errors="coerce")
notas = notas[notas["Nota"].between(1, 5)]
res = notas.groupby("Código estudiante").agg(Promedio=("Nota", "mean"),
                                             Inasistencias=("Inasistencias", "sum"))
modelo = smf.ols("Promedio ~ Inasistencias", data=res).fit()
pendiente = modelo.params["Inasistencias"]
f"Pendiente: {pendiente:.3f}  R²: {modelo.rsquared:.2f}"

# Celda 2, debajo de la anterior: el gráfico
sns.regplot(data=res, x="Inasistencias", y="Promedio")</code></pre>
<p>La pendiente dice cuánto baja el promedio por cada inasistencia y el R², qué tanto lo explican las inasistencias solas. Que haya relación no prueba causalidad; esa conversación le toca al equipo docente. Las celdas de Python se ejecutan en orden, de izquierda a derecha y de arriba abajo, por eso la segunda puede usar <code>res</code>; y para ver un resultado como celdas normales, cambia la salida a «Valor de Excel» en el menú de la celda.</p>
<h3>Camino 2: Python fuera de Excel, con IA por lotes</h3>
<p>Para miles de filas, llamadas a un modelo de lenguaje o informes semanales, conviene un script en tu computador con pandas y openpyxl. Este es el esqueleto que uso para clasificar comentarios con Gemini y devolver un informe en Excel:</p>
<pre><code>import os
import pandas as pd
from google import genai

client = genai.Client(api_key=os.environ["GEMINI_API_KEY"])
CATEGORIAS = ["Atención", "Entrega", "Precio", "Calidad del producto", "Pagos"]

def clasificar(texto: str) -> str:
    prompt = ("Clasifica el comentario en UNA de estas categorías: "
              + ", ".join(CATEGORIAS) + ". Responde solo la categoría.\n"
              + "Comentario: " + texto)
    r = client.models.generate_content(model="gemini-2.5-flash", contents=prompt)
    cat = (r.text or "").strip()
    return cat if cat in CATEGORIAS else "Revisar"

df = pd.read_excel("datos-ejemplo.xlsx", sheet_name="Encuesta")
df["Categoría"] = [clasificar(t) for t in df["Comentario"].fillna("")]
resumen = df["Categoría"].value_counts().rename_axis("Categoría").reset_index(name="Comentarios")

with pd.ExcelWriter("informe.xlsx", engine="openpyxl") as w:
    resumen.to_excel(w, sheet_name="Resumen", index=False)
    df.to_excel(w, sheet_name="Detalle", index=False)
    w.sheets["Detalle"].freeze_panes = "A2"</code></pre>
<p>Tres decisiones de diseño que importan más que el código: la respuesta se valida contra la lista de categorías (si el modelo inventa una, la fila queda en «Revisar»), los comentarios no llevan nombre ni documento del cliente y el resultado vuelve a Excel, donde lo revisa una persona. Sirve para equipos de analítica, áreas de calidad que leen PQRS e instituciones que analizan su autoevaluación anual. Para ejecutarlo instala <code>pip install pandas openpyxl google-genai</code>; el script completo de la descarga gratuita va más allá: limpia los datos con bitácora, calcula indicadores, detecta atípicos, pronostica seis meses, clasifica por lotes con caché y escribe un reporte con gráficos.</p>

<h2>Privacidad: lo que nunca debes pegar en un chat</h2>
<p>En Colombia, la Ley 1581 de 2012 protege los datos personales, da un tratamiento especial a los datos sensibles, como los de salud, y exige respetar el interés superior de niños, niñas y adolescentes. Pegar una lista de estudiantes con su diagnóstico en un chatbot gratuito no es un atajo: es un problema. Los términos de la API gratuita de Gemini dicen que Google puede usar lo que envías para mejorar sus productos, que revisores humanos pueden leerlo y piden expresamente no enviar información sensible, confidencial o personal. En los servicios de pago, Google no usa tus solicitudes para mejorar sus productos.</p>
<ul>
<li><strong>Comparte la estructura, no los registros.</strong> Nombres de columnas, tipos de dato y dos filas inventadas bastan para escribir casi cualquier fórmula.</li>
<li><strong>Anonimiza cuando necesites datos reales.</strong> Reemplaza nombres por códigos (<code>="EST-"&amp;TEXTO(FILA()-1; "000")</code>) y guarda la tabla de equivalencias solo en tu equipo.</li>
<li><strong>Agrega antes de compartir.</strong> «Curso 9B: 12 estudiantes en Bajo en Matemáticas» es útil para la IA y no identifica a nadie.</li>
<li><strong>Usa las cuentas de tu institución.</strong> Las versiones empresariales suelen proteger mejor los datos que las cuentas gratuitas.</li>
</ul>

<h2>Cómo verificar una fórmula que te dio la IA</h2>
<p>La IA escribe fórmulas con una seguridad que no siempre merece. Antes de usar una en un informe que alguien va a firmar, pásala por esta lista:</p>
<ol>
<li><strong>Entiéndela.</strong> Si no puedes explicarla, no la uses. Usa F9 sobre partes de la fórmula o Fórmulas &gt; Evaluar fórmula.</li>
<li><strong>Prueba con datos pequeños calculados a mano.</strong> Cinco filas cuyo resultado conoces de antemano.</li>
<li><strong>Busca los bordes.</strong> Celdas vacías, texto donde va un número, ceros, fechas en el último día del mes, tildes y mayúsculas, valores repetidos.</li>
<li><strong>Agrega una fila y copia la fórmula.</strong> ¿El rango crece? ¿Los signos $ están donde deben?</li>
<li><strong>Compárala con otro método.</strong> Una tabla dinámica, un filtro o una calculadora deben dar lo mismo.</li>
<li><strong>Verifica tu versión.</strong> AGRUPARPOR o REGEXREEMPLAZAR no existen en Excel 2019: quien reciba tu archivo verá <em>#¿NOMBRE?</em>.</li>
<li><strong>Comprueba idioma y separadores.</strong> Nombres en español y punto y coma en Excel en español; coma decimal en los números.</li>
<li><strong>Cuadra los totales.</strong> La suma del resumen debe ser igual a la suma de los datos.</li>
<li><strong>Déjala documentada.</strong> Una nota con qué hace, quién la revisó y cuándo.</li>
</ol>
<p>Un truco que me ha salvado varias veces: pídele a la misma IA que escriba los casos de prueba antes que la fórmula. Si los casos están mal, la fórmula también lo estará.</p>

<h2>Cuándo no usar IA</h2>
<p>No todo problema de Excel es de inteligencia artificial. Si la tarea sigue reglas fijas y se repite cada semana, una macro, Power Query o una buena plantilla son más baratas, más rápidas y siempre dan el mismo resultado. La IA brilla cuando hay que entender lenguaje, explorar o escribir el código por primera vez; la automatización, cuando hay que repetir.</p>
<table>
<thead><tr><th>Tarea</th><th>Mejor opción</th></tr></thead>
<tbody>
<tr><td>Enviar 300 correos personalizados con su adjunto</td><td>Macro (la IA puede ayudarte a escribirla una vez)</td></tr>
<tr><td>Generar certificados o cartas en PDF desde una lista</td><td>Combinación de correspondencia</td></tr>
<tr><td>Unir y limpiar el mismo reporte cada mes</td><td>Power Query</td></tr>
<tr><td>Clasificar comentarios abiertos o resumir textos</td><td>IA con revisión humana</td></tr>
<tr><td>Escribir una fórmula que no sabes construir</td><td>IA más verificación</td></tr>
<tr><td>Explorar una base nueva en busca de patrones</td><td>Analizar datos, Copilot o Python</td></tr>
</tbody>
</table>
<p>Por eso mis plantillas para tareas repetitivas no usan IA: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">enviar correos masivos con adjuntos y copias CC y CCO</a>, <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">combinar correspondencia y generar PDF individuales</a>, el <a href="/producto/generador-de-codigos-qr-masivos/">generador de códigos QR masivos</a> y la <a href="/producto/factura-con-envio-por-correo-al-cliente/">factura con envío por correo al cliente</a>. En este video de mi canal te muestro cómo funciona el envío masivo de correos con adjuntos diferentes desde Excel y Outlook:</p>
{{yt:esO3r3CJb_U|Video de Edwin Ortiz: cómo enviar correos masivos con adjuntos diferentes desde Excel, VBA y Outlook}}
<p>Y si solo necesitas una función puntual, las herramientas gratuitas de <a href="/herramientas/numero-a-letras/">número a letras</a> y <a href="/herramientas/generador-qr/">generador de códigos QR</a> traen sus propios módulos de Excel para descargar sin costo. Puedes ver todas las plantillas en la sección de <a href="/excel/">Excel y automatización</a>.</p>

<h2>Tu regalo por llegar hasta aquí: macros de IA para Excel</h2>
<p>Si leíste hasta este punto, te mereces algo más que teoría. Preparé un paquete gratuito para que pruebes lo que acabas de leer con tus propios archivos:</p>
{{img:perfil}}
{{download}}
<p>Para usar las macros necesitas la pestaña Programador. Si no la ves en tu Excel, en este video corto de mi canal te muestro cómo activarla:</p>
{{yt:dSOczB7xhTs|Video de Edwin Ortiz: cómo habilitar la pestaña Programador o Desarrollador en Excel}}
<p>Encuentras muchos más tutoriales en <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ" target="_blank" rel="noopener">mi lista de reproducción de Excel en YouTube</a>: fórmulas desde cero, macros, formularios, gráficos, códigos QR y facturas.</p>
<p class="notice"><strong>¿Te sirvió esta guía?</strong> Cuéntamelo en la sección <a href="#reacciones">«¿Te sirvió este artículo?»</a>, justo debajo: tu reacción me ayuda a saber qué ejemplos ampliar. Y si conoces a alguien que vive peleando con Excel, compártele el enlace; seguro le ahorra unas cuantas horas.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Necesito Copilot para usar IA con Excel?</h3>
<p>No. Copilot es cómodo porque trabaja dentro del libro, pero cualquier chat de IA puede escribir y explicar fórmulas, macros y consultas de Power Query para cualquier versión de Excel. Lo que sí necesitas es describir bien tus datos y verificar las respuestas.</p>
<h3>¿Qué pasó con la función =COPILOT()?</h3>
<p>Fue una función en fase beta para los programas Insider y Frontier, y Microsoft la retiró el 14 de septiembre de 2026. Los resultados ya calculados quedan guardados, pero al recalcular la celda aparece <em>#¿NOMBRE?</em>. Microsoft recomienda hacer esas tareas desde el panel de Copilot.</p>
<h3>¿Python en Excel reemplaza las fórmulas?</h3>
<p>No. Las fórmulas siguen siendo lo mejor para cálculos que otros deben leer y auditar. Python en Excel conviene para estadística, valores atípicos, regresiones y gráficos avanzados, y requiere conexión a internet porque se ejecuta en la nube de Microsoft.</p>
<h3>¿Las fórmulas sirven en Excel en inglés?</h3>
<p>Sí. Excel traduce los nombres de las funciones al abrir el archivo. Si copias una fórmula como texto, cambia los nombres (SUMAR.SI.CONJUNTO es SUMIFS) y el punto y coma por coma.</p>

<h2>Una pregunta para terminar</h2>
<p>Durante años, saber Excel fue sinónimo de saber muchas fórmulas. Hoy cualquier persona puede pedirle a una IA la fórmula perfecta en segundos. Lo que no puede pedirle es saber qué preguntar, reconocer cuándo un resultado no tiene sentido o decidir qué hacer con lo que muestran los datos. <strong>Si la IA ya escribe las fórmulas, ¿qué parte de tu trabajo con Excel es la que de verdad vale, y cuánto tiempo le estás dedicando?</strong></p>
HTML;

$download = <<<'HTML'
<p class="notice"><strong>Descarga gratis: Excel con IA.</strong> El módulo de macros <strong>ExcelConIA.bas</strong> para Excel 2016 a Microsoft 365 en Windows, un libro de datos ficticios (Ventas, Notas y Encuesta, con errores puestos a propósito para practicar), un script de Python que hace el análisis completo y una guía de instalación. Sin registro y sin costo.</p>
<ul>
<li><strong>PerfilarDatos:</strong> haces clic dentro de tu tabla y crea la hoja «Perfil de datos» con el tipo, los vacíos, los valores únicos y las estadísticas de cada columna, más alertas de tipos mezclados, números como texto, espacios sobrantes, atípicos y filas duplicadas.</li>
<li><strong>GenerarPromptIA:</strong> te pregunta qué quieres lograr y arma un prompt con la estructura y las estadísticas de la tabla, nunca con sus filas, que pide limpieza, cinco preguntas de análisis, fórmulas para tu versión de Excel y el código en pandas. Queda en el portapapeles, listo para pegar en ChatGPT, Gemini, Copilot o Claude.</li>
<li><strong>Funciones con IA:</strong> <code>=IA("Resume en 10 palabras"; A2)</code>, <code>=IA_CLASIFICAR(B2; $H$2:$H$6)</code> e <code>=IA_EXTRAER(C2; "correo")</code> llaman a Google Gemini con tu propia clave gratuita de Google AI Studio, que guardas con la macro <strong>ConfigurarIA</strong>. Las respuestas quedan en memoria para no repetir consultas, y <strong>LimpiarCacheIA</strong> las borra.</li>
</ul>
<p>Para instalarlo: desbloquea el .zip (clic derecho &gt; Propiedades &gt; Desbloquear), descomprímelo, pulsa Alt+F11, Archivo &gt; Importar archivo, eliges ExcelConIA.bas y guardas tu libro como .xlsm. PerfilarDatos y GenerarPromptIA trabajan solo en tu computador, sin internet ni clave; las funciones IA envían a Google el texto de las celdas que uses y necesitan Windows, así que úsalas con datos anonimizados. Para probar las fórmulas de este artículo con el libro de ejemplo, convierte cada hoja en tabla con Ctrl+T y ponle el nombre de la hoja.</p>
<p><a class="btn-link" href="/descargas/excel-con-ia/excel-con-ia.zip">Descargar el paquete completo (.zip)</a> <a class="btn-link" href="/descargas/excel-con-ia/ExcelConIA-modulo.zip" download>Descargar solo el módulo ExcelConIA (.zip)</a></p>
HTML;

$html = strtr($code($html), [
    '{{img:flujo}}' => $img('excel-ia-flujo', 553, 'Diagrama del flujo de datos crudos a decisiones en cinco pasos: ordenar, limpiar, analizar, interpretar y decidir, con las herramientas de cada paso (Ctrl+T, Power Query, ESPACIOS, REGEX, AGRUPARPOR, PRONOSTICO.ETS, =PY, Copilot, chat de IA) y quién lo hace: el primero y el último los haces tú; la IA acelera los del medio', 'La IA acelera los pasos del medio; ordenar los datos y decidir siguen siendo tu trabajo.'),
    '{{img:receta}}' => $img('excel-ia-receta', 645, 'Receta de prompt para Excel con seis ingredientes y un ejemplo de cada uno: versión e idioma, estructura de los datos, objetivo, restricciones, formato de respuesta y casos de prueba, más una advertencia: nunca incluyas nombres, documentos, salarios, diagnósticos ni datos de menores de edad', 'La receta de prompt que uso para pedir fórmulas: seis ingredientes y ningún dato personal.'),
    '{{img:python}}' => $img('excel-ia-python', 627, 'Diagrama de dos caminos entre Excel y Python: Python en Excel con =PY, que corre en la nube de Microsoft con pandas, seaborn y statsmodels y devuelve tablas o gráficos en la celda; y Python en tu computador con pandas, openpyxl y una API de IA por lotes, que devuelve un informe .xlsx con formato; en ambos casos con revisión humana', 'Python en Excel para análisis dentro de la celda; Python en tu computador para lotes grandes e informes recurrentes.'),
    '{{img:perfil}}' => $img('excel-ia-perfil', 620, 'Antes y después de la macro PerfilarDatos: a la izquierda, la hoja Ventas con ciudades escritas con espacios y sin tilde, un vendedor vacío, un valor atípico de 23.825.000, unidades guardadas como texto y una fila duplicada; a la derecha, la hoja Perfil de datos con 801 filas, 10 columnas, 10 filas duplicadas, 337 celdas vacías y una tabla con el tipo, los vacíos, los valores únicos y las alertas de cada columna', 'La macro PerfilarDatos convierte una hoja desordenada en un diagnóstico que puedes revisar, y GenerarPromptIA lo vuelve un prompt sin datos personales.'),
    '{{download}}' => $download,
    '{{yt:HjR1u-3KGik|Video de Edwin Ortiz: el secreto para dominar las tablas dinámicas en Excel}}' => $yt('HjR1u-3KGik', 'Video de Edwin Ortiz: el secreto para dominar las tablas dinámicas en Excel'),
    '{{yt:wtLK7qD_hOg|Video de Edwin Ortiz: cómo calcular la cuota de un préstamo en Excel con la función PAGO}}' => $yt('wtLK7qD_hOg', 'Video de Edwin Ortiz: cómo calcular la cuota de un préstamo en Excel con la función PAGO'),
    '{{yt:JncUBa3uihY|Video de Edwin Ortiz: lista de asistencia en Excel para trabajadores o estudiantes}}' => $yt('JncUBa3uihY', 'Video de Edwin Ortiz: lista de asistencia en Excel para trabajadores o estudiantes'),
    '{{yt:esO3r3CJb_U|Video de Edwin Ortiz: cómo enviar correos masivos con adjuntos diferentes desde Excel, VBA y Outlook}}' => $yt('esO3r3CJb_U', 'Video de Edwin Ortiz: cómo enviar correos masivos con adjuntos diferentes desde Excel, VBA y Outlook'),
    '{{yt:dSOczB7xhTs|Video de Edwin Ortiz: cómo habilitar la pestaña Programador o Desarrollador en Excel}}' => $yt('dSOczB7xhTs', 'Video de Edwin Ortiz: cómo habilitar la pestaña Programador o Desarrollador en Excel'),
]);

return [
    'slug' => 'excel-con-inteligencia-artificial-ejemplos-practicos-python',
    'title' => 'Excel con inteligencia artificial: ejemplos prácticos para empresas, docentes y analistas',
    'excerpt' => 'Guía práctica para usar IA con Excel: qué ofrecen hoy Copilot y Python en Excel, una receta de prompt, fórmulas reales para pymes, finanzas, talento humano, docentes y directivos, cómo verificar lo que te da la IA, cuándo no usarla y macros gratuitas para descargar.',
    'seo_title' => 'Excel con inteligencia artificial: ejemplos prácticos',
    'seo_description' => 'Cómo usar IA en Excel con ejemplos reales: Copilot, Python, prompts y fórmulas para pymes, docentes y directivos. Incluye macros gratis para descargar.',
    'focus_keyword' => 'Excel con inteligencia artificial',
    'cover' => '/assets/img/articulos/excel-ia/excel-ia-portada',
    'cover_alt' => 'Portada con el título Excel con inteligencia artificial, una hoja de cálculo Ventas.xlsx con la fórmula AGRUPARPOR que resume el total por ciudad, una tarjeta con un prompt verificado con cinco casos de prueba y una tarjeta de Python en Excel con pandas',
    'published_at' => '2026-10-07 23:00:00',
    'content_html' => $html,
];
