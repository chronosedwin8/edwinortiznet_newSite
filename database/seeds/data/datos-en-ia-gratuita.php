<?php

declare(strict_types=1);

// "Siete preguntas antes de pegar datos en una IA gratuita". Fuentes verificadas el 9 de octubre de 2026: centro de ayuda de OpenAI (controles de datos), cobertura de la política de privacidad de Gemini (no se accedió a la página original), prensa sobre el caso Samsung (abr.-may. 2023), Ley 1581 de 2012, TALIS 2024. Script de anonimización probado con texto ficticio; matriz verificada en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/datos-en-ia-gratuita/' . $name;
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
<p>Es lunes, hay que escribir veinte informes para las familias y una herramienta gratuita de IA promete hacerlo en minutos. La tentación es pegar las observaciones tal cual: nombre del estudiante, notas, el diagnóstico que reportó la familia. Es rápido, funciona y nadie se entera. <strong>Pero lo que pegas en una herramienta gratuita deja de estar bajo tu control</strong>: puede guardarse, revisarse por personas o usarse para entrenar modelos, según la herramienta y su configuración.</p>
<p>Este artículo propone <strong>siete preguntas</strong> para hacerte antes de pegar datos en una IA gratuita, una <a href="/descargas/datos-en-ia/matriz-siete-preguntas-datos-en-ia.xlsx">matriz descargable en Excel</a> que combina el tipo de dato con el tipo de herramienta, y un <a href="/descargas/datos-en-ia/anonimizar_texto.py">script en Python</a> que ayuda a quitar datos identificables, con sus límites. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Antes de pegar datos en una IA gratuita pregunta: qué datos son, si puedes anonimizarlos, si la herramienta usa tus conversaciones o las revisan personas, dónde y cuánto se guardan, qué tipo de cuenta usas, si tienes autorización y qué pasaría si se filtran. Si no sabes responder la 1 o no tienes autorización (la 6), <strong>no pegues los datos</strong>. Los datos de menores y los sensibles no deben ir a herramientas gratuitas de cuenta personal. Esta es una guía general, no asesoría jurídica.</p>

<h2>Qué puede pasar con lo que pegas</h2>
<p>Cada herramienta tiene sus propias reglas, que cambian con el tiempo; por eso conviene leerlas, y el principio es siempre el mismo: <strong>no des por hecho lo que no has verificado</strong>. Dos ejemplos de lo que se ha documentado:</p>
<ul>
<li><strong>Uso para entrenar el modelo.</strong> En ChatGPT, según el centro de ayuda de OpenAI, existe un ajuste ("Mejorar el modelo para todos") que, apagado, hace que tus conversaciones nuevas no se usen para entrenar sus modelos; sigue habiendo historial. Los controles disponibles dependen de si has iniciado sesión, del plan y de la configuración del espacio de trabajo, y no pude confirmar con las fuentes consultadas cuál es el valor por defecto para usuarios gratuitos: <strong>revísalo en tu propia cuenta</strong>.</li>
<li><strong>Revisión humana y retención.</strong> Según la cobertura de la política de privacidad de Gemini (no pude acceder a la página original de Google), las conversaciones que revisan personas, junto con datos asociados como idioma, tipo de dispositivo y ubicación, <strong>no se borran cuando eliminas tu actividad</strong>, sino que se conservan hasta tres años; desactivar la actividad evita que los chats futuros se revisen, pero Google igual los mantiene unas 72 horas. Verifica los detalles actuales en la página oficial.</li>
</ul>
<p>Y un caso conocido: en abril de 2023, ingenieros de Samsung subieron código interno a ChatGPT; según la prensa, la empresa prohibió después el uso de IA generativa en sus equipos y redes por el temor de que los datos quedaran en servidores externos, difíciles de recuperar y borrar. Si le pasó a una multinacional con sus propias reglas, puede pasarle a un colegio o a una pyme.</p>

<h2>Las siete preguntas</h2>
{{img:preguntas}}
<ol>
<li><strong>¿Sé exactamente qué datos voy a pegar?</strong> Haz la lista: nombres, documentos, correos, notas, diagnósticos, fotos, archivos adjuntos (una hoja de Excel puede traer columnas ocultas).</li>
<li><strong>¿Están anonimizados o no son necesarios?</strong> Casi siempre se puede pedir lo mismo con datos inventados o con marcadores como [ESTUDIANTE 1].</li>
<li><strong>¿Usa mis conversaciones para entrenarse o las revisan personas? ¿Lo apagué?</strong> Mira la configuración de datos y la política de privacidad.</li>
<li><strong>¿Dónde y por cuánto tiempo se guardan? ¿Puedo borrarlos?</strong> Borrar el historial puede no borrar todo (ver el caso de Gemini).</li>
<li><strong>¿Es una cuenta institucional con términos de la organización o una cuenta personal gratuita?</strong> Los términos para organizaciones suelen ser distintos; revísalos, no los supongas.</li>
<li><strong>¿Tengo autorización?</strong> De la institución y, si hay datos de menores, de las familias o de quienes los representan.</li>
<li><strong>Si estos datos se filtraran, ¿qué pasaría?</strong> Piensa en el peor caso para las personas, no para ti.</li>
</ol>
<p>La hoja "Siete_preguntas" te deja evaluar hasta tres herramientas, cuenta las respuestas "Sí" y da un veredicto: <em>"No sé" cuenta como "No"</em> y, si la pregunta 1 o la 6 es "No", el veredicto es "No pegues estos datos" sin importar el puntaje (lo probé con varios escenarios: con las siete en "Sí" dice "Puedes continuar"; con seis y sin autorización, "No pegues estos datos").</p>

<h2>La matriz: tipo de dato por tipo de herramienta</h2>
{{img:matriz}}
<p>No todo dato va en toda herramienta. La matriz del libro combina cuatro tipos de dato (público, interno no personal, personal, sensible o de menores) con tres tipos de herramienta (gratuita con cuenta personal, cuenta institucional con términos de organización y modelo local o privado) y da una de tres respuestas: <strong>Permitido</strong>, <strong>Condicionado</strong> o <strong>No</strong>. Una calculadora lo resuelve y baja el nivel de riesgo si los datos están realmente anonimizados. Por ejemplo, datos personales en una herramienta gratuita con cuenta personal dan "No"; los mismos datos en una cuenta institucional dan "Condicionado": solo con política, autorización, finalidad definida y revisión humana. "Condicionado" no significa libre.</p>
<p>El marco legal importa: la Ley 1581 de 2012 regula el tratamiento de datos personales y restringe el de niños, niñas y adolescentes, y la Superintendencia de Industria y Comercio ha emitido instrucciones sobre el tratamiento de datos personales en sistemas de inteligencia artificial (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes y personalización con IA</a>). Si tu institución tiene una política de IA, aplícala; si no, es buen momento para crearla (ver la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA para colegios</a>).</p>

<h2>Anonimizar de verdad: un ejemplo y sus límites</h2>
<p>Escribí un script de unas 40 líneas en Python (solo biblioteca estándar) que sustituye correos, teléfonos, números de documento, fechas y los nombres que tú indiques. Lo probé con un texto ficticio:</p>
<pre><code>Estudiante: Valentina Rojas Pérez, documento 1.234.567.890, nació el 14/03/2012.
Acudiente: Marta Pérez (celular 311 456 7890, correo marta.perez@correo.com).
Observación del docente: Valentina presenta dificultades de atención y su familia
reporta un diagnóstico reciente.</code></pre>
<p>Resultado:</p>
<pre><code>Estudiante: [PERSONA], documento [DOCUMENTO], nació el [FECHA].
Acudiente: [PERSONA] (celular [TELEFONO], correo [CORREO]).
Observación del docente: [PERSONA] presenta dificultades de atención y su familia
reporta un diagnóstico reciente.</code></pre>
<p>Funcionó con lo mecánico, pero fíjate en lo que <strong>no</strong> hizo: la última línea sigue diciendo que la persona (ahora "[PERSONA]") presenta dificultades de atención y un diagnóstico reciente. Eso es un <strong>dato sensible</strong> sobre una niña cuyo curso, edad o contexto podrían bastar para identificarla; cambiar el nombre no lo anonimiza. Por eso el script es una ayuda, no una garantía: <strong>no detecta direcciones, apodos ni combinaciones de datos "inocentes" que juntos identifican a alguien</strong>, y siempre hay que revisar el resultado a mano. Y si el dato es sensible, la mejor anonimización es no pegarlo: descríbelo en general ("un estudiante con dificultades de atención") o redacta esa parte tú.</p>
<p>Una técnica más segura: <strong>pídele a la IA la plantilla, no el caso</strong>. "Redacta un informe para la familia con estas secciones: avances, dificultades, recomendaciones", y llena tú los datos reales fuera de la herramienta.</p>

<h2>Qué hacer en vez de pegar</h2>
<ul>
<li><strong>Usa datos inventados</strong> que conserven la estructura del caso.</li>
<li><strong>Pide plantillas o rúbricas</strong> y complétalas fuera de la herramienta.</li>
<li><strong>Usa herramientas diseñadas para el dato.</strong> Si trabajas con documentos sensibles como un PIAR, una herramienta específica con acceso controlado es mejor que una IA genérica gratuita (ver <a href="/herramientas/piar/">PIAR con IA</a>).</li>
<li><strong>Pregunta a tu institución</strong> si hay una cuenta con términos de organización.</li>
<li><strong>Documenta</strong>: qué se usó, para qué y con qué datos (ver la bitácora de uso de IA de la rúbrica de programación en <a href="/ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion/">enseñar programación en la era de la IA</a>).</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, varias empresas y gobiernos han restringido las herramientas gratuitas de IA por riesgos de confidencialidad, y las autoridades de protección de datos han empezado a pronunciarse. En Colombia y Latinoamérica, el uso es masivo y las reglas institucionales llegan tarde: según la OCDE (TALIS 2024), alrededor del 53 % de los docentes colombianos usó IA el último año. Para los <strong>docentes</strong>, el riesgo es práctico: la tentación del atajo con datos reales; para los <strong>directivos</strong>, ofrecer una alternativa segura y una política; para las <strong>familias</strong>, saber que los datos de sus hijos no deben terminar en cuentas personales gratuitas; y para los <strong>estudiantes</strong>, aprender desde temprano a cuidar su propia información (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">controles de datos en Excel</a> para un ejemplo parecido de cuidado).</p>

<h2>Herramientas pensadas para el cuidado de los datos</h2>
<p>El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> está diseñado para que escribas el contexto y el tema, no datos de estudiantes; <a href="/herramientas/piar/">PIAR con IA</a> guarda los documentos sensibles en una cuenta con acceso controlado y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia que funcionan sin datos personales.</p>
{{productos:kit-de-ia-para-docentes,piar-con-ia-5-planes}}
<p>Sigue leyendo: <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a>, <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: los primeros 60 minutos</a> y <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Es seguro pegar datos de estudiantes en ChatGPT u otra IA gratuita?</h3>
<p>No como regla. Los datos de menores y los sensibles no deben ir a herramientas gratuitas de cuenta personal; anonimiza, usa datos inventados o una herramienta autorizada por tu institución.</p>
<h3>¿Borrar el historial borra mis datos?</h3>
<p>No necesariamente. Según la cobertura de la política de Gemini, las conversaciones revisadas por personas se conservan hasta tres años aunque borres tu actividad. Lee la política de cada herramienta.</p>
<h3>¿Cómo apago el uso de mis chats para entrenamiento?</h3>
<p>Depende de la herramienta. En ChatGPT, en Configuración, Controles de datos, hay un ajuste para dejar de usar tus conversaciones nuevas en el entrenamiento; revisa el tuyo.</p>
<h3>¿Anonimizar cambiando el nombre es suficiente?</h3>
<p>No. Un dato sensible o una combinación de datos puede identificar a una persona aunque cambies su nombre. Revisa a mano y, si es sensible, no lo pegues.</p>
<h3>¿Qué ley aplica en Colombia?</h3>
<p>La Ley 1581 de 2012 de protección de datos personales, con reglas especiales para los datos de niños, niñas y adolescentes, y las instrucciones de la Superintendencia de Industria y Comercio. Consulta con tu asesor jurídico qué aplica a tu caso.</p>

<p class="notice"><strong>Antes del próximo informe.</strong> Descarga la <a href="/descargas/datos-en-ia/matriz-siete-preguntas-datos-en-ia.xlsx">matriz de siete preguntas</a>, evalúa la herramienta que más usas y revisa la hoja "Que_quitar". Si trabajas con texto, prueba el <a href="/descargas/datos-en-ia/anonimizar_texto.py">script de anonimización</a> con el <a href="/descargas/datos-en-ia/ejemplo_texto.txt">texto de ejemplo</a>, recordando que no sustituye tu criterio.</p>

<h2>Para pensar</h2>
<p>Las herramientas gratuitas no son gratuitas: se pagan con atención o con datos. <strong>¿Es aceptable que el trabajo docente, ya sobrecargado, dependa de herramientas que obligan a decidir entre ahorrar tiempo y proteger los datos de los estudiantes? ¿Y quién debería asumir el costo de ofrecer alternativas seguras: cada docente, cada colegio o el Estado?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:preguntas}}' => $img('datos-en-ia-gratuita-preguntas', 467, 'Siete preguntas de control antes de pegar datos en una IA: datos, anonimizar, uso de chats, retención, tipo de cuenta, autorización e impacto.', 'Una lista de control antes de pegar datos.'),
    '{{img:matriz}}' => $img('datos-en-ia-gratuita-matriz', 499, 'Tabla con el tipo de dato frente a la herramienta: público permitido en ambas, interno no personal condicionado en la gratuita y permitido en la institucional, personal y sensible no en la gratuita y condicionado en la institucional.', 'No todo dato va en toda herramienta.'),
]);

return [
    'slug' => 'siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz',
    'title' => 'Siete preguntas antes de pegar datos en una IA gratuita (y una matriz para decidir qué se puede pegar)',
    'excerpt' => 'Qué puede pasar con lo que pegas en una herramienta de IA gratuita, siete preguntas de control, una matriz de tipo de dato por tipo de herramienta en Excel y un script de anonimización probado, con sus límites.',
    'seo_title' => 'Datos en una IA gratuita: siete preguntas antes de pegar',
    'seo_description' => 'Siete preguntas y una matriz para decidir qué datos pegar en una IA gratuita, con un script de anonimización probado, sus límites y el marco de la Ley 1581.',
    'focus_keyword' => 'datos en una IA gratuita privacidad',
    'cover' => '/assets/img/articulos/datos-en-ia-gratuita/datos-en-ia-gratuita-portada',
    'cover_alt' => 'Portada "Siete preguntas antes de pegar datos en una IA gratuita" con una tarjeta de cuatro de las preguntas: qué datos voy a pegar, puedo quitarlos, usan mis chats para entrenar y tengo autorización.',
    'published_at' => '2026-12-08 12:00:00',
    'content_html' => $html,
];
