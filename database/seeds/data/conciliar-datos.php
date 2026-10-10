<?php

declare(strict_types=1);

// "Un dato, varias versiones". Matriz de fuente de verdad verificada en Excel 16 (12 datos: 5 controlados, 4 copia manual, 1 copia sin sincronizar, 1 varios maestros, 1 sin fuente; 7 requieren acción; 1 sensible con copia no controlada). Conciliador en Python probado con CSV ficticios y contraste independiente: 30 y 29 filas, 27 en ambos, 2 solo en A, 1 solo en B, 1 cero perdido, 3 normalizables, 6 conflictos reales. Ley 1581 de 2012 (principio de veracidad o calidad) con aviso de verificar.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/conciliar-datos/' . $name;
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
<p>El boletín dice que Camila está en 8A. En el aula virtual aparece en 8B. En el equipo de Teams de matemáticas de 8A no está, y en el de 8B sí, con un correo que tiene una letra de más. La coordinadora pregunta cuál es el dato correcto y la respuesta honesta es que <strong>hay cuatro versiones del mismo dato y nadie sabe cuál manda</strong>. Esto ocurre cuando un colegio usa un sistema de gestión escolar, un aula virtual y una plataforma de colaboración, y es uno de los costos ocultos de la acumulación de plataformas.</p>
<p>Este artículo propone dos herramientas para ponerle orden: una <a href="/descargas/conciliar-datos/matriz-fuente-de-verdad.xlsx">matriz de fuente de verdad en Excel</a>, que define para cada dato qué sistema es el maestro, quién lo edita y cómo se sincroniza, y un <a href="/descargas/conciliar-datos/conciliador.py">conciliador en Python</a> que compara los listados de dos sistemas y reporta dónde difieren. Se prueba con dos CSV ficticios (<a href="/descargas/conciliar-datos/sistema-gestion.csv">sistema-gestion.csv</a> y <a href="/descargas/conciliar-datos/aula-virtual.csv">aula-virtual.csv</a>). Los resultados del script se contrastaron con un cálculo independiente y la matriz se verificó en Microsoft Excel 16. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Los nombres de plataformas (por ejemplo, sistemas de gestión escolar como Phidias, aulas virtuales como Moodle o espacios de colaboración como Microsoft Teams) son <strong>ejemplos</strong>; el método sirve con cualquier par de sistemas que exporten a CSV. Los datos son ficticios. Los listados reales contienen datos personales de menores: trátalos con las reglas de protección de datos de tu institución, no los subas a servicios externos y borra los archivos de trabajo cuando termines.</p>

<h2>Por qué aparecen las varias versiones</h2>
<ul>
<li><strong>Entradas manuales en cada sistema.</strong> Alguien digita el curso en el sistema de gestión y otra persona lo digita de nuevo en el aula virtual; cualquier error de una de las dos copias crea una diferencia.</li>
<li><strong>Sincronizaciones parciales o desactualizadas.</strong> Una integración que corre una vez al semestre deja pasar meses de cambios (ver <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">por qué las integraciones fallan en silencio</a>).</li>
<li><strong>Cambios que solo se hacen en un lado.</strong> Se corrige un nombre en la plataforma donde se detectó el error, pero no en el sistema de origen; en la siguiente sincronización el error vuelve.</li>
<li><strong>Diferencias de formato.</strong> Tildes, mayúsculas, espacios dobles, ceros iniciales que se pierden al abrir un CSV en una hoja de cálculo (ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">cómo importar CSV a Excel sin dañar cédulas y fechas</a>).</li>
<li><strong>Nadie es dueño del dato.</strong> Cuando "es de todos", no se corrige nunca.</li>
</ul>
<p>Los costos son concretos: boletines con información equivocada, estudiantes sin acceso a la clase que les corresponde o con acceso a una que no, cuentas duplicadas, acudientes que no reciben comunicados y reportes oficiales (por ejemplo, de matrícula) que no coinciden con lo que el colegio tiene.</p>

<h2>La idea central: una fuente de verdad por dato</h2>
<p>Una <strong>fuente de verdad</strong> (o sistema maestro) es el lugar donde un dato se crea y se corrige; los demás sistemas lo reciben como copia. No significa que todo viva en un solo programa, sino que <strong>para cada dato hay un solo maestro</strong>. Por ejemplo: el documento, el nombre y el curso se mantienen en el sistema de gestión; el correo institucional y la cuenta de usuario, en la plataforma de colaboración; las tareas y actividades, en el aula virtual. Las copias se actualizan desde el maestro; nunca se corrige una copia sin corregir el maestro.</p>
<p>La Ley 1581 de 2012 de protección de datos personales incluye, entre sus principios, el de veracidad o calidad: la información sujeta a tratamiento debe ser veraz, completa, exacta, actualizada, comprobable y comprensible (verifica el texto vigente). Mantener una fuente de verdad es una forma práctica de cumplirlo.</p>

<h2>La matriz de fuente de verdad</h2>
<p>La hoja <em>Campos</em> lista los datos (doce en el ejemplo) y, para cada uno, marca en cada sistema si es <strong>Maestro</strong>, <strong>Copia</strong> o <strong>Local</strong>, quién lo edita, si es sensible y cómo se sincroniza (automática, manual o ninguna). Un cálculo automático cuenta los maestros y las copias y asigna un riesgo:</p>
<pre><code>' Riesgo del dato (maestros en H, copias en I, sincronización en G)
=SI(H5=0;"Sin fuente de verdad";
   SI(H5>1;"Varios maestros";
   SI(Y(I5>0;G5="Manual");"Copia manual";
   SI(Y(I5>0;G5="Ninguna");"Copia sin sincronizar";"Controlado"))))     ' español

=IF(H5=0,"Sin fuente de verdad",IF(H5>1,"Varios maestros",IF(AND(I5>0,G5="Manual"),"Copia manual",IF(AND(I5>0,G5="Ninguna"),"Copia sin sincronizar","Controlado"))))   ' inglés</code></pre>
<p>En el ejemplo ficticio, de 12 datos solo <strong>5 están controlados (42 %)</strong>; 4 son copias que se actualizan a mano (el nombre, el curso, la fotografía y la cuenta de usuario), 1 es una copia sin sincronización (la asistencia), 1 tiene dos sistemas que se creen maestros (las notas finales) y 1 no tiene fuente de verdad (el estado de la matrícula, que existe en los tres y no se sabe cuál manda). Además, un dato sensible (la fotografía) tiene copias que dependen de una actualización manual. El resumen cuenta cuántos datos requieren acción: 7 de 12.</p>

<h2>El conciliador en Python</h2>
<p>El script <code>conciliador.py</code> compara dos CSV por una columna llave (aquí, el código del estudiante) y reporta: registros que están en un sistema y no en el otro, llaves que difieren solo por ceros iniciales, diferencias de formato que desaparecen al normalizar y <strong>conflictos reales</strong> campo por campo. Usa solo la biblioteca estándar de Python 3.8 o superior, lee los archivos en UTF-8 y no los modifica.</p>
<pre><code>python conciliador.py sistema-gestion.csv aula-virtual.csv --llave codigo --campos nombre,correo,curso --nombres Gestión Aula

Gestión: 30 filas | Aula: 29 filas | en ambos: 27
Solo en Gestión (2): ['0027', '0029']
Solo en Aula (1): ['0099']
Posible cero inicial perdido (1): 0012 / 12
Diferencias que desaparecen al normalizar tildes, mayúsculas y espacios: 3
Conflictos en "nombre": 2
   0004: Gestión="Andrea Gómez" | Aula="Andrea Gómez Ruiz"
   0005: Gestión="Camilo Torres" | Aula="Camilo Torrez"
Conflictos en "correo": 2
   0006: Gestión="lucia.mora@colegio.example" | Aula="lucia.mora@colegio.example.com"
   0007: Gestión="santiago.vega@colegio.example" | Aula="santiago.vega@colegio.exmaple"
Conflictos en "curso": 2
   0008: Gestión="7B" | Aula="8A"
   0010: Gestión="7A" | Aula="8B"
Total de conflictos reales: 6</code></pre>
<p>Los números coinciden con un cálculo independiente hecho sobre los mismos archivos. Dos puntos de este resultado merecen atención:</p>
<ul>
<li><strong>Las tres diferencias de formato no son errores.</strong> "María Pérez" frente a "MARIA PEREZ", "José  Díaz" (con dos espacios) frente a "Jose Diaz" y "ÁNGEL Ruiz" frente a "Ángel Ruiz" se resuelven al normalizar. Reportarlas como conflictos llenaría el informe de ruido y escondería los problemas reales. Eso sí: conviene decidir una forma canónica de escribir los nombres.</li>
<li><strong>El cero perdido es la diferencia más traicionera.</strong> El código "0012" aparece como "12" en el aula virtual; para un programa que compare cadenas, son dos estudiantes distintos (uno "ausente" de cada lado). El script detecta que difieren solo por ceros a la izquierda y lo reporta como un caso aparte, para que el origen del problema (una importación que trató el código como número) se corrija en lugar de crear un estudiante nuevo.</li>
</ul>
<p>En resumen, de los 30 estudiantes del sistema de gestión, <strong>9 tienen un problema real</strong> en la comparación: 2 no están en el aula virtual, 1 tiene el código con el cero perdido y 6 tienen datos en conflicto (2 nombres, 2 correos y 2 cursos); además, hay un registro en el aula virtual que no corresponde a ningún estudiante de la lista maestra.</p>
{{img:tipos}}

<h2>Cómo conciliar sin hacer un desastre</h2>
{{img:pasos}}
<ol>
<li><strong>Exporta los dos listados el mismo día,</strong> con la misma llave. Una diferencia de una semana entre exportaciones produce diferencias que no son errores.</li>
<li><strong>Guarda la llave como texto.</strong> Si abres el CSV en una hoja de cálculo, impórtalo especificando la columna como texto; de lo contrario perderás los ceros iniciales.</li>
<li><strong>Normaliza antes de comparar</strong> (tildes, mayúsculas, espacios) y revisa cuántas diferencias eran solo de formato.</li>
<li><strong>Corrige en el sistema maestro,</strong> no en la copia, y deja que se propague. Si corriges la copia, el error volverá en la próxima sincronización.</li>
<li><strong>Repite la conciliación</strong> antes de cada corte de notas y al inicio de cada periodo, y guarda el informe como evidencia.</li>
<li><strong>Trata los archivos como lo que son:</strong> datos personales de menores. Acceso limitado, sin copias en correos personales ni carpetas compartidas abiertas, y eliminación al terminar.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios reportan su matrícula a los sistemas del sector (en educación básica y media, al sistema de matrícula que administran las entidades territoriales y el Ministerio), y lo que el colegio reporta debe coincidir con lo que tiene en sus sistemas internos; muchos usan además una plataforma de gestión escolar, un aula virtual y herramientas de colaboración, cada una con su propia lista. En la región, la integración de datos escolares es un reto frecuente, con instituciones que operan con hojas de cálculo y otras con plataformas integradas; en el mundo, la gestión de datos maestros es una disciplina establecida, y su principio básico es el mismo que aquí: un dato, un dueño, un maestro. Para los <strong>directivos</strong>, definir qué sistema manda es una decisión de gobierno de datos, no técnica; para el <strong>personal de sistemas</strong>, la matriz da un mapa para priorizar integraciones; para los <strong>docentes</strong>, evita que "su lista" difiera de la oficial; y para las <strong>familias</strong>, que la comunicación les llegue a la persona correcta. Ver también <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">más plataformas no es mejor</a> y <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA gratuita</a>.</p>

<h2>Plantillas y herramientas</h2>
<p>Si necesitas plantillas de Excel ya armadas, con soporte, o apoyo para tus procesos administrativos, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">una mesa de ayuda para el colegio</a>, <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">inventario tecnológico con trazabilidad</a> y <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">flujo de aprobación digital</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es una fuente de verdad?</h3>
<p>El sistema donde un dato se crea y se corrige; los demás sistemas lo reciben como copia. Debe haber una por cada dato.</p>
<h3>¿Por qué un mismo estudiante aparece con datos distintos en dos plataformas?</h3>
<p>Por digitación manual en cada sistema, sincronizaciones parciales o desactualizadas, correcciones hechas solo en la copia y diferencias de formato.</p>
<h3>¿Cómo comparo dos listados sin cometer errores de formato?</h3>
<p>Con una llave común guardada como texto y normalizando tildes, mayúsculas y espacios antes de comparar.</p>
<h3>¿Por qué se pierden los ceros iniciales?</h3>
<p>Porque al abrir un CSV en una hoja de cálculo, un código como 0012 se interpreta como número y se convierte en 12. Se evita importando la columna como texto.</p>
<h3>¿El conciliador modifica mis archivos?</h3>
<p>No. Solo lee los dos CSV y escribe el informe en pantalla.</p>

<p class="notice"><strong>Empieza por la matriz.</strong> Descarga la <a href="/descargas/conciliar-datos/matriz-fuente-de-verdad.xlsx">matriz de fuente de verdad</a>, anota tus datos y tus sistemas y mira cuántos están controlados. Luego prueba el <a href="/descargas/conciliar-datos/conciliador.py">conciliador</a> con los CSV de ejemplo antes de usarlo con tus listados.</p>

<h2>Para pensar</h2>
<p>Cuando un dato tiene varias versiones, alguien paga el precio: casi siempre el estudiante o su familia. <strong>¿Quién es, en tu colegio, el dueño de cada dato, y qué pasa cuando dos personas lo corrigen a la vez? Y si hoy compararas dos listados de tus sistemas, ¿cuántos estudiantes aparecerían con una versión distinta de sí mismos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pasos}}' => $img('conciliar-datos-pasos', 467, 'Cinco pasos de la conciliación mensual: exportar, normalizar, comparar, corregir y repetir.', 'La conciliación, paso a paso.'),
    '{{img:tipos}}' => $img('conciliar-datos-tipos', 553, 'Tabla con cinco tipos de diferencia entre dos listados, un ejemplo y qué hacer: ausente, cero perdido, formato, conflicto y sobrante.', 'No todas las diferencias son iguales.'),
]);

return [
    'slug' => 'un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador',
    'title' => 'Un dato, varias versiones: conciliar el sistema de gestión, el aula virtual y Teams con una matriz y un conciliador en Python',
    'excerpt' => 'Por qué el mismo estudiante aparece con datos distintos en cada plataforma y cómo ordenarlo: una matriz de fuente de verdad en Excel y un conciliador en Python que encuentra ausentes, ceros perdidos y conflictos entre dos listados.',
    'seo_title' => 'Conciliar datos entre plataformas del colegio',
    'seo_description' => 'Cómo conciliar los listados del sistema de gestión, el aula virtual y Teams: matriz de fuente de verdad en Excel y conciliador en Python.',
    'focus_keyword' => 'conciliar datos entre plataformas',
    'cover' => '/assets/img/articulos/conciliar-datos/conciliar-datos-portada',
    'cover_alt' => 'Portada "Un dato, varias versiones: conciliar la gestión escolar, el aula virtual y Teams" con una tarjeta: 9 de 30 estudiantes tienen un problema real entre dos sistemas.',
    'published_at' => '2027-02-02 12:00:00',
    'content_html' => $html,
];
