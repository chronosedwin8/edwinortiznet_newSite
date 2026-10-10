<?php

declare(strict_types=1);

// «Clases que funcionen sin conexión: un modelo de planificación». Fuentes verificadas el 9 de octubre de 2026: ITU Facts and Figures 2025; estudio de la Universidad Javeriana con datos del DANE (formulario C600) reportado por El País (22-abr-2025); Learning Equality (Kolibri). Planificador verificado en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/clases-sin-conexion/' . $name;
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
<p>Una docente prepara una clase con un video, una simulación interactiva y una plataforma de ejercicios. Llega al aula y no hay internet. O hay, pero se cae a los cinco minutos con treinta estudiantes conectados. O no hay energía. La clase planeada con tanto cuidado se convierte en una espera. Para muchos docentes de Colombia y de la región, no es un caso raro: <strong>es el lunes</strong>.</p>
<p>Este artículo propone un modelo de planificación «<strong>offline-first</strong>»: diseñar la clase para que logre su resultado de aprendizaje <strong>sin necesidad de conexión</strong>, y usar la conexión, si existe, como un extra. Incluye un <a href="/descargas/clases-sin-conexion/planificador-clase-sin-conexion.xlsx">planificador descargable en Excel</a> con un ejemplo de 90 minutos, un paquete de materiales y un plan B. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Una clase robusta separa dos momentos: <strong>prepararse con conexión</strong> (descargar, imprimir, probar) y <strong>enseñar sin depender de ella</strong>. Cada actividad se marca como «No», «Opcional» o «Sí» según necesite red, y toda actividad tiene un plan B. El objetivo no es renunciar a la tecnología, sino que <strong>los estudiantes sin conexión no queden sin clase</strong>.</p>

<h2>Por qué importa: los datos</h2>
<p>Según el informe Facts and Figures 2025 de la Unión Internacional de Telecomunicaciones (ITU), cerca de 6.000 millones de personas usaban internet en 2025, pero <strong>2.200 millones seguían sin conexión</strong>; el uso es del 85 % en zonas urbanas y del 58 % en las rurales. En Colombia, un estudio del Laboratorio de Economía de la Educación de la Universidad Javeriana con datos del formulario C600 del DANE, reportado por El País (22 de abril de 2025), estimó que <strong>el 40 % de las sedes educativas del país no tenía internet</strong> (más de 21.000) y que cerca del 10 % (unas 4.700) no tenía energía eléctrica; entre los departamentos con más sedes sin internet aparecían Vaupés (84,3 %), Amazonas (81,3 %) y Vichada (79,5 %), frente al 0,6 % de Bogotá. Son cifras de una fuente secundaria que citan un estudio, y pueden haber cambiado; pero muestran la dimensión del problema. Incluso donde hay internet, hay límites de calidad: una conexión que sirve para un correo no sirve para treinta videos al tiempo.</p>
{{img:brecha}}
<p>La consecuencia pedagógica: <strong>una clase que depende de la red amplía la desigualdad</strong> en vez de cerrarla, porque quienes ya están más conectados reciben más clase. (Ver también <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">la deuda tecnológica de los colegios</a>.)</p>

<h2>El modelo en cinco pasos</h2>
{{img:pasos}}
<ol>
<li><strong>Define el resultado de aprendizaje y la evidencia</strong> sin mencionar herramientas: «ordenar fracciones y explicar el razonamiento», no «usar la simulación X».</li>
<li><strong>Elige actividades que no requieran red:</strong> material físico, trabajo en parejas, tablero, cuaderno, juegos con tarjetas, el patio. Lo digital entra como complemento.</li>
<li><strong>Prepara un paquete de materiales antes</strong> (con conexión): descarga lo necesario, imprime guías y tarjetas y guarda copias en un USB y en el computador. Y <strong>pruébalo sin conexión</strong>: pon el equipo en modo avión y abre cada archivo; un video que «sí cargaba» puede depender de la red.</li>
<li><strong>Marca la dependencia de cada actividad</strong> (No, Opcional, Sí) y escribe un plan B. Una actividad que dependa de la conexión sin plan B es un riesgo.</li>
<li><strong>Sincroniza después:</strong> sube lo que corresponda, revisa tareas y descarga lo nuevo cuando haya conexión.</li>
</ol>

<h2>Un ejemplo: fracciones en 90 minutos</h2>
<p>El planificador trae una clase de matemáticas de sexto grado con seis actividades y la dependencia de cada una:</p>
<table>
<thead><tr><th>Actividad</th><th>Min.</th><th>Conexión</th><th>Plan B</th></tr></thead>
<tbody>
<tr><td>Calentamiento: ¿qué parte del chocolate?</td><td>10</td><td>No</td><td>Dibujar en el cuaderno</td></tr>
<tr><td>Modelo con tiras de papel: comparar 1/2, 2/3 y 3/4</td><td>20</td><td>No</td><td>Dibujar rectángulos</td></tr>
<tr><td>Recta numérica en el piso con cinta</td><td>15</td><td>No</td><td>Dibujar con tiza en el patio</td></tr>
<tr><td>Simulación interactiva (demostración)</td><td>15</td><td>Opcional</td><td>Hacerla en el tablero</td></tr>
<tr><td>Práctica: ordenar seis fracciones</td><td>20</td><td>No</td><td>Dictar las fracciones</td></tr>
<tr><td>Cierre: explicar un caso por escrito</td><td>10</td><td>No</td><td>Hacerlo en voz alta en parejas</td></tr>
</tbody>
</table>
<p>El libro calcula, con fórmulas, que de los 90 minutos <strong>ninguno necesita conexión</strong>, 15 la usan como opcional (la simulación, que se descarga antes y se abre sin red) y la lectura es «La clase funciona sin conexión». Probé el caso inverso: si marcas la simulación como «Sí», el libro dice que el 17 % del tiempo depende de la conexión y pide revisar el plan B. La hoja «Paquete_de_materiales» suma el tamaño de lo que descargas (en el ejemplo, 58 MB: cabe holgado en un USB), avisa de los materiales sin copia de respaldo y de los no probados sin conexión, y la hoja «Plan_B» cubre qué hacer si fallan internet, energía, proyector, dispositivos o un archivo.</p>

<h2>Herramientas que ayudan</h2>
<ul>
<li><strong>Material impreso y manipulativos:</strong> la tecnología más confiable es la que no necesita energía.</li>
<li><strong>Plataformas pensadas para trabajar sin conexión.</strong> Kolibri, de la organización sin ánimo de lucro Learning Equality, es una plataforma de código abierto «offline-first»: se carga el contenido desde internet, un USB u otro dispositivo en red local, y los estudiantes lo usan desde tabletas o computadores conectados a un servidor del aula; sincroniza datos cuando hay conexión. Según la información consultada, su biblioteca reúne materiales en más de 173 idiomas. Revisa las condiciones de licencia y la privacidad de cualquier plataforma antes de adoptarla (ver la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a> y las <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a>).</li>
<li><strong>Formatos abiertos:</strong> PDF, imágenes y HTML simples abren en cualquier equipo; evita los que exigen una cuenta o un servicio en línea para abrirse.</li>
<li><strong>Exámenes y guías imprimibles:</strong> prepararlos con tiempo permite trabajar sin pantallas.</li>
</ul>

<h2>Cómo evaluar sin conexión</h2>
<p>La evaluación formativa casi no necesita red: preguntas de salida en una tarjeta, respuestas en tablillas, explicaciones orales en parejas, observación del trabajo con material concreto. Para la evaluación final, un examen impreso con rúbrica es perfectamente válido. Lo importante es recoger <strong>evidencia de aprendizaje</strong> y no depender de que una plataforma la registre (ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>).</p>

<h2>Lo que no se debe hacer</h2>
<ul>
<li><strong>Asumir que «todos tienen internet en casa».</strong> Ver los datos.</li>
<li><strong>Dejar tareas que exigen conexión sin alternativa:</strong> penaliza a quien no puede.</li>
<li><strong>Usar videos largos como actividad central</strong> en un aula donde la red es inestable.</li>
<li><strong>No probar el material sin conexión</strong> antes de la clase.</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la brecha digital se concentra en países de ingresos bajos y medios y en zonas rurales; ITU estima que el 96 % de quienes siguen sin conexión viven en países de ingresos bajos y medios. En Colombia, la conectividad escolar ha crecido, pero sigue siendo muy desigual entre territorios. Por eso la clase sin conexión no es solo para zonas apartadas: también la necesita el colegio urbano cuando falla la red o la energía. Para los <strong>docentes</strong>, planear con plan B es una forma de cuidar su clase; para los <strong>directivos</strong>, decidir qué tecnología se compra pensando en la conectividad real (ver <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribirse o desarrollar</a>); para las <strong>familias</strong>, no se debería exigir lo que no pueden dar; y para los <strong>estudiantes</strong>, que el aprendizaje no dependa del código postal.</p>

<h2>Herramientas para el docente</h2>
<p>Para planear y producir material imprimible, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia que te ayudan a preparar el paquete con tiempo, y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> entrega exámenes y soluciones que puedes imprimir y aplicar sin conexión. También hay una <a href="/examenes/demo/">demostración gratuita</a>.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">una prueba de cuatro semanas para evaluar una herramienta</a> y <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía pedagógica ante las plataformas</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué significa «offline-first»?</h3>
<p>Diseñar para que todo funcione sin conexión, y usar la conexión, si existe, para sincronizar o ampliar. Es lo contrario de diseñar para la red y «parchar» cuando falla.</p>
<h3>¿Cómo preparo un paquete de materiales?</h3>
<p>Con conexión, descarga lo necesario, imprime guías y tarjetas, guarda copias en un USB y en el computador, y prueba cada archivo en modo avión antes de la clase.</p>
<h3>¿Puedo usar simulaciones y videos si no hay internet?</h3>
<p>Sí, si los descargas antes y los abres sin red. Verifica que el archivo funcione sin conexión y marca la actividad como «Opcional», con un plan B.</p>
<h3>¿Cómo mando tareas si los estudiantes no tienen internet en casa?</h3>
<p>Con guías impresas o actividades en el cuaderno, y evita las que exijan plataformas. Si hay conexión, ofrécela como complemento.</p>
<h3>¿Existen plataformas para trabajar sin conexión?</h3>
<p>Sí. Kolibri es un ejemplo de plataforma de código abierto pensada para uso sin conexión. Evalúa su licencia, privacidad y adecuación a tu currículo antes de adoptarla.</p>

<p class="notice"><strong>Esta semana:</strong> toma una clase que ya planeaste, pásala por el <a href="/descargas/clases-sin-conexion/planificador-clase-sin-conexion.xlsx">planificador</a>, marca la dependencia de cada actividad y escribe el plan B de las que dependen de la red. Después, prueba tu paquete en modo avión.</p>

<h2>Para pensar</h2>
<p>Cada vez que planeamos una clase que supone conexión, decidimos, sin decirlo, para quién es la clase. <strong>¿Es la desconexión un problema de infraestructura que corresponde al Estado resolver, o es también un problema de diseño pedagógico que cada docente puede atender hoy? Y mientras la conexión llega a todas las sedes, ¿qué estamos dispuestos a dejar de hacer en clase para que nadie se quede por fuera?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:brecha}}' => $img('clases-sin-conexion-brecha', 573, 'Cuatro tarjetas con datos de conectividad: 2.200 millones de personas sin conexión en el mundo en 2025, uso de internet del 85 % urbano frente al 58 % rural, 40 % de las sedes educativas de Colombia sin internet y 84,3 % en Vaupés frente a 0,6 % en Bogotá.', 'Una clase que dependa de la red deja a muchos fuera.'),
    '{{img:pasos}}' => $img('clases-sin-conexion-pasos', 467, 'Cinco pasos para planear una clase sin depender de la red: definir el resultado, elegir actividades sin red, preparar el paquete antes, marcar dependencias con plan B y sincronizar después.', 'Cinco pasos del diseño «offline-first».'),
]);

return [
    'slug' => 'clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first',
    'title' => 'Clases que funcionen cuando no hay internet: un modelo de planificación «offline-first» con plan B',
    'excerpt' => 'Cómo diseñar una clase que logre su resultado de aprendizaje con o sin conexión: datos de la brecha de conectividad, cinco pasos, un ejemplo de 90 minutos y un planificador en Excel con paquete de materiales y plan B.',
    'seo_title' => 'Clases sin conexión: planificación offline-first',
    'seo_description' => 'Cómo planear clases que funcionen sin internet: datos de conectividad en Colombia, cinco pasos, un ejemplo de 90 minutos y un planificador descargable.',
    'focus_keyword' => 'clases sin conexión a internet',
    'cover' => '/assets/img/articulos/clases-sin-conexion/clases-sin-conexion-portada',
    'cover_alt' => 'Portada «Clases que funcionen cuando no hay internet: un modelo de planificación» con una tarjeta: el 40 % de las sedes educativas del país no tenía internet, más de 21.000 sin conexión y cerca de 4.700 sin electricidad.',
    'published_at' => '2026-12-09 12:00:00',
    'content_html' => $html,
];
