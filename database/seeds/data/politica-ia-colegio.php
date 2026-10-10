<?php

declare(strict_types=1);

// "Política institucional de IA para colegios". Fuentes verificadas el 9 de octubre de 2026: UNESCO, guía sobre IA generativa en educación (2023, vía cobertura); Gallup-Walton (jun. 2025); TALIS 2024; GAD3 vía El Tiempo (ago. 2026); Ley 1581 de 2012. No se encontraron lineamientos nacionales específicos para colegios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/politica-ia-colegio/' . $name;
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
<p>En muchos colegios, la inteligencia artificial ya entró por la puerta de atrás: los estudiantes la usan para las tareas, algunos docentes la usan para planear y casi nadie sabe, con claridad, qué está permitido. Cuando no hay reglas, cada docente improvisa la suya, un mismo trabajo es "fraude" en un salón y "buen uso" en otro, y los datos de los estudiantes terminan en herramientas que nadie evaluó.</p>
<p>Este artículo propone cómo construir una <strong>política institucional de IA</strong> breve y aplicable, organizada en tres categorías: usos <strong>permitidos</strong>, <strong>condicionados</strong> y <strong>no autorizados</strong>. Incluye una <a href="/descargas/politica-ia-colegio/matriz-politica-ia-colegio.xlsx">matriz descargable en Excel</a> con 16 usos para docentes, estudiantes y directivos, una evaluación de herramientas y una plantilla de declaración de uso. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Una política de IA no se escribe para prohibir ni para aplaudir la tecnología, sino para dejar claro <strong>quién decide qué</strong>: la IA puede asistir; las decisiones sobre las personas (notas finales, sanciones, promoción) y el cuidado de los datos de los menores siguen en manos de humanos que responden por ellas. La política se construye con la comunidad educativa, se prueba y se revisa cada año.</p>

<h2>Por qué hace falta</h2>
<p>Tres datos ayudan a dimensionar el asunto, con sus límites:</p>
<ul>
<li>Una encuesta de Gallup y la Fundación Walton en EE. UU. (junio de 2025, con más de 2.000 docentes) encontró que en las escuelas con una política de IA el beneficio declarado fue un 26 % mayor. Es un dato de EE. UU. y autorreportado, pero apunta a que <strong>las reglas claras hacen que la tecnología rinda más</strong>.</li>
<li>Según la OCDE (TALIS 2024), alrededor del 53 % de los docentes colombianos usó IA en el último año, más que el promedio de la OCDE (36 %). El uso crece más rápido que las reglas.</li>
<li>Un estudio de GAD3 para Planeta Formación y Universidades, reportado por El Tiempo en agosto de 2026, indica que el 84 % de los estudiantes de educación superior en Colombia usa IA generativa de forma habitual y que solo el 35 % tiene competencias para usarla más allá de un nivel básico. Es educación superior (no colegios) y el medio no informa la muestra, así que se cita solo como señal.</li>
</ul>
<p>Sobre las reglas: en septiembre de 2023, la UNESCO publicó su primera guía global sobre IA generativa en educación y propuso <strong>13 años como edad mínima</strong> para usar estas herramientas en el aula, aclarando que muchos consideran ese umbral demasiado bajo; pidió además que las instituciones validen los sistemas antes de ponerlos a disposición de los estudiantes y que se adopten estándares de protección de datos. Es una recomendación, no una norma colombiana. En Colombia, hasta donde pude verificar el 9 de octubre de 2026, <strong>no encontré lineamientos nacionales específicos para el uso de IA en colegios</strong> (el Ministerio de Educación ha publicado orientaciones para la educación superior, y existe la Política Nacional de IA, CONPES 4144 de 2025); conviene confirmarlo en el sitio del Ministerio. Mientras tanto, la política institucional es el lugar donde cada colegio decide.</p>

<h2>Las tres categorías</h2>
{{img:categorias}}
<ul>
<li><strong>Permitido:</strong> usos de bajo riesgo, sin datos personales y sin afectar la evaluación. Ejemplo: adaptar un texto a otro nivel de lectura.</li>
<li><strong>Condicionado:</strong> usos valiosos que solo se aceptan si se cumple una condición concreta. Ejemplo: un borrador de retroalimentación que el docente revisa y firma como suyo.</li>
<li><strong>No autorizado:</strong> usos que afectan decisiones sobre personas, comprometen datos de menores o son deshonestos. Ejemplo: asignar la nota final con un sistema automático.</li>
</ul>
<p>La clave es que <strong>cada "condicionado" tenga una condición verificable y un responsable</strong>; si no, es un "permitido" disfrazado.</p>

<h2>La matriz: 16 usos para empezar</h2>
<p>El libro descargable trae una propuesta inicial; con ella, 2 usos quedan permitidos, 6 condicionados y 8 no autorizados. Estos son algunos:</p>
<table>
<thead><tr><th>Quién</th><th>Uso</th><th>Categoría</th><th>Condición o razón</th></tr></thead>
<tbody>
<tr><td>Docente</td><td>Generar borradores de planeación o rúbricas</td><td>Condicionado</td><td>El docente revisa, corrige y adapta</td></tr>
<tr><td>Docente</td><td>Calificar o definir la nota final automáticamente</td><td>No autorizado</td><td>La evaluación es decisión del docente</td></tr>
<tr><td>Docente</td><td>Pegar datos de estudiantes en una IA pública</td><td>No autorizado</td><td>Datos de menores: solo en herramientas autorizadas</td></tr>
<tr><td>Docente</td><td>Detector de IA como prueba única para acusar</td><td>No autorizado</td><td>No son concluyentes; se requiere diálogo y evidencia del proceso</td></tr>
<tr><td>Estudiante</td><td>Pedir explicaciones o ejemplos</td><td>Condicionado</td><td>Cuenta institucional o supervisión y declaración de uso</td></tr>
<tr><td>Estudiante</td><td>Entregar texto de IA como propio</td><td>No autorizado</td><td>Falta de honestidad académica según el manual</td></tr>
<tr><td>Estudiante</td><td>Usar IA siendo menor de 13 años</td><td>No autorizado</td><td>Solo con cuenta institucional, supervisión y autorización familiar</td></tr>
<tr><td>Directivo</td><td>Decidir admisiones, sanciones o promoción con IA</td><td>No autorizado</td><td>Decisiones sobre personas: las toma un humano</td></tr>
</tbody>
</table>
<p>Dos puntos merecen explicación. Primero, <strong>los detectores de IA</strong>: no hay una forma confiable de probar que un texto lo escribió una máquina, y acusar a un estudiante con base en un detector puede ser injusto; es mejor evaluar el proceso (borradores, defensa oral, trabajo en clase) y aplicar el debido proceso del manual de convivencia (ver <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">si la IA amplía o reemplaza el pensamiento</a>). Segundo, <strong>los datos de los menores</strong>: la Ley 1581 de 2012 restringe el tratamiento de datos de niños, niñas y adolescentes y exige asegurar su interés superior; por eso la regla es no ingresar datos identificables en herramientas no autorizadas (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes y personalización con IA</a>).</p>

<h2>Cómo construirla en cuatro semanas</h2>
<ol>
<li><strong>Semana 1: diagnóstico.</strong> Pregunta a docentes y estudiantes (anónimamente) qué herramientas usan y para qué. Seguramente te sorprenderás.</li>
<li><strong>Semana 2: borrador con la comunidad.</strong> Parte de la matriz y discútela con docentes, estudiantes, familias y directivos. Lo que se decide con la comunidad se respeta más.</li>
<li><strong>Semana 3: piloto.</strong> Prueba la política en uno o dos grupos y la declaración de uso en una tarea real; ajusta lo que no funcione.</li>
<li><strong>Semana 4: aprobación y comunicación.</strong> Aprueba en el consejo directivo, incorpora lo necesario al manual de convivencia y comunícalo con ejemplos concretos.</li>
<li><strong>Después: revisión.</strong> Al menos una vez al año, o cuando cambien la norma o una herramienta importante.</li>
</ol>

<h2>Evaluar una herramienta antes de autorizarla</h2>
<p>La hoja "Evaluacion_herramienta" trae nueve preguntas: ¿hay una necesidad concreta?, ¿se conoce qué datos recoge y para qué?, ¿permite cuentas institucionales?, ¿dónde se almacenan los datos y pueden eliminarse?, ¿el proveedor los usa para entrenar sus modelos?, ¿se puede usar con supervisión y sin que el menor cree una cuenta personal?, ¿hay evidencia independiente?, ¿hay responsable y plan de salida?, ¿se informó a las familias? Si las preguntas sobre datos tienen respuesta "no", no se autoriza (ver <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">la deuda tecnológica de los colegios</a> y <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribir o desarrollar</a>).</p>

<h2>La declaración de uso: honestidad en lugar de caza de brujas</h2>
<p>En vez de perseguir el uso de IA, pide a los estudiantes que lo <strong>declaren</strong>: qué herramienta usaron, para qué, qué pidieron, qué parte es suya y cómo verificaron la información. El libro incluye la plantilla. Declarar cambia la conversación: del "¿lo copiaste?" al "¿qué aprendiste y cómo lo comprobaste?". Es coherente con la idea de que la tarea de verdad es el pensamiento del estudiante (ver <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía pedagógica ante las plataformas</a> y <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, las políticas de IA en educación van desde prohibiciones totales hasta integraciones guiadas; lo común en las mejores prácticas es la combinación de alfabetización, reglas claras y protección de datos, como propone la UNESCO. En Colombia y Latinoamérica el desafío es doble: las desigualdades de acceso (no todos los estudiantes tienen las mismas herramientas en casa) y la falta de lineamientos específicos, lo que deja la decisión en manos de cada institución. Para los <strong>directivos</strong>, liderar el proceso y rendir cuentas; para los <strong>docentes</strong>, tener claridad y apoyo para usar la IA con criterio; para los <strong>estudiantes</strong>, aprender a usarla con honestidad; para las <strong>familias</strong>, saber qué datos de sus hijos se usan y poder opinar.</p>

<h2>Herramientas que ya cumplen estas reglas</h2>
<p>Las herramientas que construyo están pensadas para que el docente decida: el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> entrega el examen y sus soluciones para que el docente los revise antes de usarlos; <a href="/herramientas/piar/">PIAR con IA</a> redacta borradores que el equipo de expertos valida y no reemplaza su criterio; y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia que se adaptan, no se copian. Son ejemplos de usos "condicionados" bien resueltos.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a> y <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Un colegio está obligado a tener una política de IA?</h3>
<p>Hasta donde pude verificar, no hay una obligación nacional específica para colegios; pero tenerla es una buena práctica, y el manual de convivencia y la autonomía institucional permiten incorporarla.</p>
<h3>¿Deben los colegios prohibir ChatGPT y herramientas similares?</h3>
<p>Una prohibición total es difícil de hacer cumplir y no enseña a usarlas con criterio. Es más realista definir qué usos se permiten, cuáles se condicionan y cuáles no, y enseñar a verificar.</p>
<h3>¿Pueden los menores de 13 años usar IA?</h3>
<p>La UNESCO recomienda 13 años como mínimo en el aula y muchos proveedores fijan su propia edad. Por precaución, la matriz exige cuenta institucional, supervisión y autorización de la familia.</p>
<h3>¿Sirven los detectores de IA para sancionar?</h3>
<p>No como prueba única: no son concluyentes. Evalúa el proceso del estudiante y aplica el debido proceso del manual de convivencia.</p>
<h3>¿Cada cuánto se revisa la política?</h3>
<p>Al menos una vez al año, y antes si cambia la norma o se adopta una herramienta importante.</p>

<p class="notice"><strong>Empieza con la matriz.</strong> Descarga la <a href="/descargas/politica-ia-colegio/matriz-politica-ia-colegio.xlsx">matriz de política de IA</a>, cámbiala con tu comunidad educativa y prueba la declaración de uso en una tarea. Incluye la evaluación de herramientas.</p>

<h2>Para pensar</h2>
<p>Una política de IA se escribe para proteger a los estudiantes y al oficio de enseñar, pero también puede convertirse en una forma de control. <strong>¿Quién debería tener voz en las reglas sobre IA en un colegio: solo directivos y docentes, o también los estudiantes que van a vivir con estas herramientas toda su vida? Y si una regla prohíbe lo que los estudiantes de colegios con más recursos pueden usar libremente en casa, ¿estamos protegiendo o ampliando la brecha?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:categorias}}' => $img('politica-ia-colegio-categorias', 444, 'Tabla con las tres categorías de una política de IA: permitido, con un ejemplo y su regla; condicionado, y no autorizado.', 'Las tres categorías de una política de IA.'),
]);

return [
    'slug' => 'politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar',
    'title' => 'Política institucional de IA para colegios: qué permitir, qué condicionar y qué no autorizar',
    'excerpt' => 'Cómo construir una política de IA breve y aplicable para un colegio, con tres categorías de uso, una matriz de 16 usos para docentes, estudiantes y directivos, una evaluación de herramientas y una declaración de uso.',
    'seo_title' => 'Política de IA para colegios: qué permitir y qué no',
    'seo_description' => 'Construye una política de IA para tu colegio: usos permitidos, condicionados y no autorizados, con matriz descargable y evaluación de herramientas.',
    'focus_keyword' => 'política de IA para colegios',
    'cover' => '/assets/img/articulos/politica-ia-colegio/politica-ia-colegio-portada',
    'cover_alt' => 'Portada "Política institucional de IA para colegios: qué permitir, qué condicionar y qué no autorizar" con una lista: adaptar un texto y un borrador revisado por el docente, marcados; nota final automática y datos de menores en IA pública, descartados.',
    'published_at' => '2026-11-18 12:00:00',
    'content_html' => $html,
];
