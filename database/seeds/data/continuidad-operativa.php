<?php

declare(strict_types=1);

// "Plan de continuidad operativa del colegio". Conceptos: BIA, RTO, RPO (ISO 22301; NIST SP 800-34, citados como referencia general). Libro verificado en Excel 16 y Python: 8 procesos; 6 con brecha de tiempo (máx. 24 h: pagos y matrículas); 4 con brecha de datos; 3 sin alternativa manual y con las tres debilidades; prioridad 1 plataforma de notas (4,7; 11,75), 2 pagos (4,2; 10,5), 3 evaluaciones en línea (3,8; 9,5). Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/continuidad-operativa/' . $name;
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
<p>Es el último día de notas del periodo. A las 10 de la mañana la plataforma del colegio deja de responder. El proveedor dice que "está trabajando en ello". Los docentes tienen las notas en sus cuadernos y, en el mejor de los casos, en una hoja de cálculo de hace dos semanas. Las familias esperan los boletines al día siguiente. Nadie sabe cuánto va a durar, quién decide qué hacer ni qué se puede hacer mientras tanto. <strong>La tecnología va a fallar alguna vez; lo que se puede decidir de antemano es cuánto cuesta cuando falle.</strong></p>
<p>Este artículo propone un <strong>plan de continuidad operativa</strong> para un colegio: no un documento de cien páginas, sino un análisis sencillo de qué procesos no pueden parar, cuánto tiempo y cuántos datos se pueden perder, y qué se hace mientras el sistema no está. Incluye un <a href="/descargas/continuidad-operativa/analisis-impacto-continuidad-operativa.xlsx">libro de Excel</a> con un análisis de impacto de ocho procesos, un índice de prioridad y una hoja de escenarios, verificado en Microsoft Excel 16 y contra un cálculo independiente. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es un marco básico inspirado en prácticas de gestión de continuidad del negocio (por ejemplo, la norma ISO 22301 y guías como NIST SP 800-34), simplificado para un colegio; no es una implementación certificada ni asesoría de seguridad. Los procesos, los tiempos y los pesos del ejemplo son ficticios y editables. La Ley 1581 de 2012 incluye entre los principios del tratamiento de datos personales el de seguridad (medidas técnicas, humanas y administrativas); verifica con tu institución qué exige su política de protección de datos.</p>

<h2>El vocabulario de la continuidad</h2>
{{img:terminos}}
<ul>
<li><strong>Análisis de impacto (BIA, <em>business impact analysis</em>):</strong> la identificación de los procesos críticos y de qué pasa si se interrumpen.</li>
<li><strong>RTO (<em>recovery time objective</em>):</strong> el tiempo máximo que un proceso puede estar caído antes de que el daño sea inaceptable. Es lo que la institución <em>puede tolerar</em>.</li>
<li><strong>RPO (<em>recovery point objective</em>):</strong> la cantidad máxima de datos que se puede perder, medida en tiempo: si el último respaldo tiene 24 horas, se pierde hasta un día de trabajo.</li>
<li><strong>Alternativa manual:</strong> cómo se sigue operando sin el sistema (listados impresos, hojas de contingencia, comunicación por teléfono).</li>
</ul>
<p>La diferencia entre lo que se <em>tolera</em> (RTO y RPO objetivo) y lo que <em>realmente ocurre</em> (el tiempo real de recuperación y la antigüedad del último respaldo) es la <strong>brecha</strong>, y cerrarla es el trabajo del plan.</p>

<h2>El libro de Excel</h2>
<ul>
<li><strong>Procesos:</strong> ocho procesos del colegio (plataforma de notas, correo institucional, pagos y matrículas, aula virtual, comunicación con familias, red y Wi-Fi, registro de asistencia y evaluaciones en línea), cada uno con tres impactos de 1 a 5 (académico, en familias, legal o financiero), el RTO y el RPO objetivo en horas, el tiempo real de recuperación, la antigüedad del último respaldo y si hay alternativa manual.</li>
<li>Calcula la <strong>criticidad</strong> (promedio ponderado de los tres impactos: 40 % académico, 30 % familias, 30 % legal o financiero; editable), las <strong>brechas</strong> de tiempo y de datos y un <strong>índice de prioridad</strong> con su posición.</li>
<li><strong>Escenarios:</strong> cinco escenarios (corte de internet, falla de la plataforma de notas, ransomware, pérdida de energía y ausencia del único responsable técnico), con los procesos afectados, la primera acción, el responsable y la alternativa mientras tanto.</li>
<li><strong>Resumen:</strong> los conteos clave.</li>
</ul>
<pre><code>' Criticidad de un proceso (pesos en D2, E2 y F2)
=REDONDEAR(D5*$D$2+E5*$E$2+F5*$F$2;2)                         ' español
=ROUND(D5*$D$2+E5*$E$2+F5*$F$2,2)                              ' inglés

' Brecha de tiempo: lo que tarda de más frente a lo tolerable (nunca negativa)
=MAX(0;I5-G5)

' Brecha de datos: respaldo más viejo de lo tolerable
=SI(O(H5="";J5="");0;MAX(0;J5-H5))

' Índice de prioridad: la criticidad pesa más si hay brechas o no hay alternativa manual
=REDONDEAR(L5*(1+0,5*(M5>0)+0,5*(N5>0)+0,5*(K5="No"));2)

' Posición (1 = la más urgente)
=JERARQUIA(O5;$O$5:$O$25;0)</code></pre>
<p>El índice de prioridad es un criterio de elaboración propia, no una norma: la idea es que un proceso <em>crítico</em> con brechas y sin alternativa debe ir primero, y uno poco crítico con una alternativa razonable puede esperar. Ajusta los pesos a tu realidad.</p>

<h2>Lo que muestra el ejemplo (datos ficticios)</h2>
<ul>
<li><strong>6 de 8 procesos con brecha de tiempo:</strong> se tardarían más en recuperar de lo que tolera la institución. La mayor, de <strong>24 horas</strong>, es la de pagos y matrículas (se tardaría 48 horas frente a una tolerancia de 24), seguida por el correo institucional (20 horas más de lo tolerable: 24 reales frente a 4).</li>
<li><strong>4 de 8 con brecha de datos:</strong> el último respaldo es más viejo de lo tolerable. La plataforma de notas tolera perder 4 horas de datos y su último respaldo tiene 24, una brecha de 20 horas; las evaluaciones en línea tienen una brecha de 23 horas.</li>
<li><strong>3 de 8 sin alternativa manual:</strong> la plataforma de notas, los pagos y matrículas y las evaluaciones en línea. Y esos mismos tres procesos tienen <strong>las tres debilidades a la vez</strong> (brecha de tiempo, brecha de datos y sin alternativa).</li>
<li><strong>Prioridad:</strong> 1.º la plataforma de notas (criticidad 4,7; índice 11,75), 2.º pagos y matrículas (4,2; 10,5) y 3.º evaluaciones en línea (3,8; 9,5). Los procesos con alternativa manual, aun con brechas, quedan más abajo.</li>
</ul>
<p>La conclusión práctica: con tiempo y presupuesto limitados, <strong>empezar por tres cosas</strong>: respaldar la plataforma de notas con más frecuencia (una brecha de datos de 20 horas es la más grave), preparar una hoja de contingencia para los pagos y las evaluaciones, y acordar con el proveedor un tiempo de recuperación realista (por escrito). Las brechas del correo y de la comunicación con familias son importantes, pero tienen alternativas (teléfono, mensajería).</p>

<h2>Qué se hace mientras el sistema no está</h2>
<p>La hoja de escenarios del libro obliga a pensar de antemano algo que, en una crisis, se improvisa mal: <strong>quién hace qué</strong>. Ejemplos del libro: ante un corte de internet de la sede, el responsable de sistemas llama al proveedor y activa datos móviles de respaldo mientras los docentes usan material impreso y actividades sin conexión; ante una falla de la plataforma de notas, coordinación contacta al proveedor, exporta la última copia y usa una hoja de contingencia con copia protegida; ante un ataque de ransomware, se aíslan los equipos y se sigue el protocolo de los primeros 60 minutos (ver <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">qué hacer en los primeros 60 minutos de un ransomware</a>); ante la ausencia del único responsable técnico, se activa al suplente con credenciales de emergencia.</p>
{{img:pasos}}

<h2>Cinco pasos para armar el plan</h2>
<ol>
<li><strong>Identifica los procesos que no pueden parar,</strong> con las personas que los conocen (no solo con sistemas). Pregunta: "si esto falla un lunes por la mañana, ¿qué pasa y cuánto aguantamos?".</li>
<li><strong>Mide el impacto y la tolerancia</strong> de cada uno (RTO y RPO objetivo).</li>
<li><strong>Compara con la realidad:</strong> ¿cuánto tardaría de verdad recuperarlo?, ¿de cuándo es el último respaldo y se ha probado restaurarlo? (ver <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>).</li>
<li><strong>Cierra las brechas por orden de prioridad:</strong> respaldos más frecuentes, restauraciones probadas, alternativas manuales preparadas, contratos con tiempos de respuesta, un suplente técnico.</li>
<li><strong>Prueba el plan con un simulacro</strong> corto y ajusta. Un plan que nunca se ha probado es una hipótesis.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios dependen cada vez más de plataformas para notas, matrícula, comunicación y clases, muchas veces alojadas fuera de la institución y con contratos que no precisan tiempos de recuperación. En la región el panorama es similar, con una capacidad técnica muy desigual; en el mundo, la gestión de continuidad es una disciplina madura con normas (como ISO 22301) y guías públicas, y los incidentes de ransomware contra escuelas han mostrado el costo de no estar preparados. Para los <strong>directivos</strong>, el plan es una decisión de gestión de riesgo, no un tema técnico; para el <strong>personal de sistemas</strong>, el análisis da argumentos y prioridades para pedir recursos; para los <strong>docentes</strong>, saber qué hacer cuando falla una herramienta evita improvisar frente a los estudiantes; y para las <strong>familias</strong>, la continuidad es parte de la confianza. Ver también <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">una mesa de ayuda para el colegio</a>, <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">el inventario tecnológico</a> y <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a>.</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de plantillas de Excel ya armadas, con soporte, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">qué monitorear en una aplicación web</a>, <a href="/implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel/">implementar una plataforma en 30 días</a> y <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es un plan de continuidad operativa?</h3>
<p>Un conjunto de decisiones tomadas de antemano sobre qué procesos no pueden parar, cuánto se tolera su caída y qué se hace mientras el sistema no está disponible.</p>
<h3>¿Qué son el RTO y el RPO?</h3>
<p>El RTO es el tiempo máximo que un proceso puede estar caído; el RPO, la cantidad máxima de datos que se puede perder, medida en tiempo desde el último respaldo.</p>
<h3>¿Un respaldo en la nube es suficiente?</h3>
<p>No necesariamente: importa cada cuánto se hace, si se ha probado restaurarlo y cuánto tarda la recuperación. Ver "la nube no es un respaldo".</p>
<h3>¿Por dónde empiezo?</h3>
<p>Por el proceso más crítico con más brechas y sin alternativa manual: en el ejemplo, la plataforma de notas.</p>
<h3>¿Cada cuánto debo probar el plan?</h3>
<p>Al menos una vez al año con un simulacro corto, y después de cambios importantes (una plataforma nueva, un cambio de proveedor).</p>

<p class="notice"><strong>Haz tu análisis esta semana.</strong> Descarga el <a href="/descargas/continuidad-operativa/analisis-impacto-continuidad-operativa.xlsx">análisis de impacto</a>, reemplaza los procesos por los tuyos, completa los tiempos con quienes los conocen y mira cuáles quedan primero en prioridad.</p>

<h2>Para pensar</h2>
<p>Un plan de continuidad es, en el fondo, una conversación honesta sobre lo que no queremos que falle y lo que hoy pasaría si fallara. <strong>¿Cuántas de las respuestas de este libro las conoce hoy quien lidera tu colegio, y cuántas las está suponiendo? Y si mañana a las 10 a. m. dejara de funcionar tu plataforma principal, ¿qué sabrían hacer, sin preguntar, los docentes?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:terminos}}' => $img('continuidad-operativa-terminos', 499, 'Tabla con cuatro términos de la gestión de continuidad, su significado y la pregunta que responde cada uno: BIA, RTO, RPO y alternativa manual.', 'El vocabulario de la continuidad.'),
    '{{img:pasos}}' => $img('continuidad-operativa-pasos', 467, 'Cinco pasos para armar un plan de continuidad: identificar, medir, comparar, cerrar brechas y probar.', 'Cinco pasos, de lo crítico a la prueba.'),
]);

return [
    'slug' => 'plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel',
    'title' => 'Plan de continuidad operativa del colegio: qué hacer cuando la tecnología falla, con análisis de impacto (RTO y RPO) en Excel',
    'excerpt' => 'Un plan de continuidad para el colegio: identificar procesos críticos, medir cuánto se tolera su caída y cuántos datos se pueden perder (RTO y RPO), comparar con la realidad y definir qué hacer mientras tanto, con un libro de Excel y cinco escenarios.',
    'seo_title' => 'Plan de continuidad operativa del colegio (RTO y RPO)',
    'seo_description' => 'Cómo armar un plan de continuidad para el colegio: procesos críticos, RTO y RPO, brechas, alternativas manuales y escenarios, con libro de Excel.',
    'focus_keyword' => 'plan de continuidad operativa del colegio',
    'cover' => '/assets/img/articulos/continuidad-operativa/continuidad-operativa-portada',
    'cover_alt' => 'Portada "Plan de continuidad operativa del colegio: qué hacer cuando la tecnología falla" con una tarjeta: 3 de 8 procesos con tres debilidades, lenta recuperación, respaldo viejo y sin alternativa.',
    'published_at' => '2027-02-16 12:00:00',
    'content_html' => $html,
];
