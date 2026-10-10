<?php

declare(strict_types=1);

// "Implementar una plataforma en 30 días". Plan verificado en Excel 16 y Python: 14 tareas, 41 días-tarea, termina el día 30, 1 problema de secuencia (T9), 4/4/2/4 por semana, 4 de 14 tareas de sistemas, puntaje de decisión 3,65. Ley 1581 de 2012 art. 7 (datos de niños, niñas y adolescentes) con aviso de verificar. Marco propio.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/plan-30-dias/' . $name;
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
<p>El colegio compra una plataforma en diciembre "para que los docentes la usen desde enero". En marzo, la usan tres docentes. En junio, nadie se acuerda de la contraseña. No fue un problema de tecnología: fue un problema de implementación. <strong>La mayoría de los fracasos de una plataforma educativa se deciden antes de que se use por primera vez</strong>, cuando no se definió qué problema debía resolver, no se revisaron los riesgos y se decidió escalar sin haber probado.</p>
<p>Este artículo propone un <strong>plan de implementación en 30 días</strong>: cuatro semanas para definir, preparar, probar con un piloto y decidir con evidencia si continuar, ajustar o cerrar. Incluye un <a href="/descargas/plan-30-dias/plan-implementacion-30-dias.xlsx">libro de Excel</a> con un plan de 14 tareas con sus predecesoras, un diagrama de Gantt automático, un control de secuencia y una hoja de decisión con seis criterios ponderados, verificado en Microsoft Excel 16 y contra un cálculo independiente. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es un marco de gestión de proyectos simplificado, no una metodología certificada, y el plan, las tareas, los responsables y los criterios del ejemplo son ficticios y editables. Un piloto de 30 días permite decidir si vale la pena seguir, pero no demuestra por sí solo que la plataforma mejora el aprendizaje: para eso se necesita una evaluación más larga (ver <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">cómo probar una herramienta educativa en cuatro semanas</a>). Las exigencias legales sobre datos personales, contratos y compras dependen de tu institución: consúltalas.</p>

<h2>Por qué 30 días y por qué un piloto</h2>
<p>Treinta días es suficiente para aprender lo esencial (¿funciona con nuestros datos?, ¿la entienden los docentes?, ¿cuánto soporte exige?) y corto para que el costo de equivocarse sea bajo. El piloto es la pieza central: <strong>probar con pocos grupos y datos de prueba antes de comprometer a toda la institución</strong>. Permite descubrir los problemas cuando todavía es barato arreglarlos, y da una base de evidencia propia, no solo la del proveedor. Esto conecta con una lección de la <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">deuda tecnológica</a>: cada plataforma que se adopta sin evaluar se vuelve costo de mantenimiento, de integración y de formación.</p>
{{img:semanas}}

<h2>El plan, semana por semana</h2>
<p><strong>Semana 1 (días 1 a 7): definir y revisar.</strong> Tareas: definir el problema y los criterios de éxito (¿qué indicador cambiaría si funciona?); nombrar responsables y el equipo piloto; revisar privacidad, contrato y costos. Entregable: un documento de una página con el problema, los criterios y los riesgos. Preguntas de la revisión: ¿qué datos de estudiantes recibe la plataforma y dónde se almacenan?, ¿quién es el responsable del tratamiento y qué dice el contrato sobre la eliminación de datos?, ¿cuál es el costo total a tres años (ver <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">el costo total de comprar, suscribir o desarrollar</a>)?, ¿tiene un plan de salida si decides cambiar? Si la plataforma usa IA, ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a> y la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política de IA del colegio</a>.</p>
<p><strong>Semana 2 (días 8 a 14): configurar y preparar.</strong> Configurar cuentas, roles y permisos; cargar <strong>datos de prueba, no reales</strong>; preparar materiales y una guía rápida; capacitar al equipo piloto. Entregable: un entorno configurado y un equipo capacitado. Regla de oro: <strong>no cargues datos reales de estudiantes hasta haber revisado el contrato y los permisos.</strong> En Colombia, la Ley 1581 de 2012 de protección de datos personales limita el tratamiento de datos de niños, niñas y adolescentes (su artículo 7 exige que responda y respete el interés superior de los menores y sus derechos fundamentales); verifica con tu institución qué autorizaciones se requieren.</p>
<p><strong>Semana 3 (días 15 a 21): piloto.</strong> Piloto con dos grupos (o los que tu capacidad de soporte permita), recolección de retroalimentación de docentes y estudiantes y ajustes de configuración. Entregable: datos de uso y una lista de problemas con su gravedad. Registra los incidentes: este es el momento de aplicar la lógica de la <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">mesa de ayuda</a> (prioridad, plazo y tiempo de respuesta del proveedor).</p>
<p><strong>Semana 4 (días 22 a 30): ampliar, medir y decidir.</strong> Piloto ampliado, medición de los indicadores definidos el primer día, sesión de decisión y plan de despliegue o de cierre ordenado. Entregable: una decisión documentada.</p>

<h2>El libro de Excel</h2>
<ul>
<li><strong>Plan:</strong> una fila por tarea con responsable, inicio, duración, predecesora y, calculados, el fin, el fin de la predecesora, un <em>control</em> de secuencia, la semana de inicio y un <strong>diagrama de Gantt</strong> de 30 columnas que se pinta solo con formato condicional.</li>
<li><strong>Decision:</strong> seis criterios con peso y puntaje de 1 a 5; calcula el puntaje ponderado y una lectura.</li>
<li><strong>Resumen:</strong> tareas, días-tarea, último día, tareas con problema, tareas por semana y tareas por equipo.</li>
</ul>
<pre><code>' Fin de una tarea (el día de inicio cuenta como el primer día)
=SI(D4="";"";D4+E4-1)                                   ' español
=IF(D4="","",D4+E4-1)                                   ' inglés

' Fin de la predecesora (buscándola por su ID)
=SI.ERROR(INDICE($F$4:$F$40;COINCIDIR(G4;$A$4:$A$40;0));"No existe")

' Control de secuencia: una tarea no debe empezar antes de que termine su predecesora
=SI(D4<=H4;"Empieza antes de que termine su predecesora";SI(F4>30;"Pasa del día 30";"OK"))

' Celda del Gantt para el día 15 (se pinta cuando el valor es 1)
=SI(Y(15>=$D4;15<=$F4);1;"")</code></pre>
<p>Con el ejemplo de 14 tareas, la suma de duraciones es de <strong>41 días-tarea</strong> y la última termina el <strong>día 30</strong>. El control detecta <strong>una tarea con problema de secuencia</strong>: la recolección de retroalimentación (T9) empieza el día 18, el mismo día en que termina el piloto (T8), de modo que no tiene tiempo de recoger lo que el piloto produce; hay que moverla al día 19. Es un error clásico: planear como si las tareas encajaran sin holgura. Por semana de inicio, hay 4 tareas en la semana 1, 4 en la 2, 2 en la 3 y 4 en las semanas 4 y 5; y <strong>4 de las 14 tareas (29 %) dependen del equipo de sistemas</strong>, un cuello de botella probable si es una sola persona (ver <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">una mesa de ayuda para el colegio</a>).</p>

<h2>La decisión: seis criterios con peso</h2>
<p>El día 29 se decide con criterios fijados al inicio, no con la impresión del último día. La hoja <em>Decision</em> propone seis criterios con pesos (suma 100 %): resuelve el problema definido (25 %), facilidad de uso (20 %), privacidad y seguridad (20 %), integración con lo que ya se usa (15 %), costo total razonable a tres años (10 %) y soporte y dependencia del proveedor (10 %). Con los puntajes de ejemplo (4, 3, 5, 3, 4 y 2), el puntaje ponderado es de <strong>3,65</strong> sobre 5; con un umbral de 3,5, la lectura es "continuar, con ajustes en los criterios más bajos": soporte (2), facilidad de uso (3) e integración (3). La hoja también advierte si algún criterio crítico está en 1 (en tal caso la recomendación es cerrar o corregir antes de seguir) y si los pesos no suman 100 %. Los umbrales y los pesos son del ejemplo: define los tuyos antes del piloto.</p>

<h2>Cinco errores que el plan intenta evitar</h2>
{{img:pasos}}
<ol>
<li><strong>Empezar por la herramienta y no por el problema.</strong> "Queremos usar IA/una plataforma" no es un problema. "Los docentes tardan tres horas en entregar notas" sí lo es, y se puede medir.</li>
<li><strong>Saltarse la revisión de datos y contrato</strong> porque "todos la usan".</li>
<li><strong>Escalar sin piloto</strong> o con un piloto sin criterios: el piloto no decide si nadie definió qué significa que funcione.</li>
<li><strong>Subestimar la capacitación y el soporte.</strong> Una plataforma sin acompañamiento se vuelve un archivo más.</li>
<li><strong>No prever la salida.</strong> Si no sabes cómo recuperar tus datos y cerrar, estás atado al proveedor (ver <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">por qué las integraciones fallan en silencio</a> y <a href="/un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador/">un dato, varias versiones</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios adoptan plataformas por iniciativa propia, por programas de entidades territoriales o por la presión de las familias, y es frecuente que la decisión se tome por precio o por moda. En la región ocurre lo mismo, con el agravante de que la capacidad técnica de las instituciones es muy desigual; en el mundo, la literatura sobre adopción de tecnología educativa insiste en que el éxito depende más del acompañamiento y del uso pedagógico que de la herramienta. Para los <strong>directivos</strong>, el plan convierte una compra en una decisión con evidencia; para los <strong>docentes</strong>, el piloto es una oportunidad de opinar antes de que la herramienta se imponga; para el <strong>personal de sistemas</strong>, ordena el trabajo y hace visible su carga; y para las <strong>familias</strong>, la revisión de datos es una garantía de cuidado. Ver también <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a> y <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">el inventario tecnológico</a>.</p>

<h2>Plantillas y herramientas</h2>
<p>Si necesitas plantillas de Excel ya armadas, con soporte, o apoyo para tus procesos administrativos, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">flujo de aprobación digital</a>, <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">qué monitorear en una aplicación web</a> y <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">qué hacer en los primeros 60 minutos de un ransomware</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué un piloto antes de implementar?</h3>
<p>Porque permite descubrir problemas de configuración, datos, uso y soporte cuando todavía es barato corregirlos, y decidir con evidencia propia.</p>
<h3>¿Cuántos grupos debe tener el piloto?</h3>
<p>Los que tu capacidad de soporte permita atender bien: normalmente dos o tres grupos al inicio, ampliando después si todo va bien.</p>
<h3>¿Puedo usar datos reales de estudiantes en el piloto?</h3>
<p>Primero con datos de prueba. Los datos reales solo después de revisar el contrato, los permisos y las autorizaciones que exija la normativa de protección de datos y tu institución.</p>
<h3>¿Qué hago si el piloto sale mal?</h3>
<p>Cerrarlo a tiempo es un buen resultado: evitó un costo mayor. Documenta lo aprendido y recupera o elimina los datos según el contrato.</p>
<h3>¿Sirve este plan para una plataforma con IA?</h3>
<p>Sí, añadiendo la revisión específica de qué datos entran a los modelos, cómo se almacenan y si se usan para entrenar; ver la política de IA y las preguntas antes de pegar datos.</p>

<p class="notice"><strong>Planea tu piloto.</strong> Descarga el <a href="/descargas/plan-30-dias/plan-implementacion-30-dias.xlsx">plan de 30 días</a>, ajusta las tareas y los responsables a tu caso, fija los criterios de decisión antes de empezar y revisa que ninguna tarea empiece antes de que termine su predecesora.</p>

<h2>Para pensar</h2>
<p>Una plataforma que nadie usa no es neutra: consume dinero, tiempo de formación y confianza. <strong>¿Quién en tu colegio tiene hoy la autoridad para decir "esta plataforma no funcionó, la cerramos"? Y si la respuesta es nadie, ¿qué estamos dispuestos a pagar por no admitir un error?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:semanas}}' => $img('plan-30-dias-semanas', 499, 'Tabla con las cuatro semanas de un plan de implementación de 30 días, el objetivo y el entregable de cada una.', 'Cada semana cierra con un entregable.'),
    '{{img:pasos}}' => $img('plan-30-dias-pasos', 467, 'Cinco pasos antes de escalar una plataforma: problema, riesgos, piloto, medir y decidir.', 'Cinco pasos que evitan un fracaso costoso.'),
]);

return [
    'slug' => 'implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel',
    'title' => 'Implementar una plataforma en el colegio en 30 días: plan, piloto y decisión de continuar, ajustar o cerrar (libro de Excel)',
    'excerpt' => 'Un plan de cuatro semanas para implementar una plataforma en el colegio: definir, preparar, hacer un piloto y decidir con seis criterios ponderados, con un libro de Excel con diagrama de Gantt y control de secuencia.',
    'seo_title' => 'Implementar una plataforma en el colegio en 30 días',
    'seo_description' => 'Plan de 30 días para implementar una plataforma en el colegio: definir, preparar, piloto y decisión con criterios, con libro de Excel y diagrama de Gantt.',
    'focus_keyword' => 'implementar una plataforma en el colegio',
    'cover' => '/assets/img/articulos/plan-30-dias/plan-30-dias-portada',
    'cover_alt' => 'Portada "Implementar una plataforma en el colegio en 30 días: un plan con decisión" con una tarjeta: 30 días para probar una plataforma con un piloto y decidir con evidencia.',
    'published_at' => '2027-02-09 12:00:00',
    'content_html' => $html,
];
