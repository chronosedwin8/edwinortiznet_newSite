<?php

declare(strict_types=1);

// Análisis con datos: verificación de las afirmaciones populares sobre el sistema educativo de Finlandia, su caída en PISA (2000–2025) y comparación con Colombia y América Latina.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/finlandia/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

$pisa25 = 'https://www.oecd.org/content/dam/oecd/en/publications/reports/2026/09/pisa-2025-results-volume-i_5265bfb1/73451bc5-en.pdf';

return [
    'slug' => 'finlandia-sistema-educativo-mito-o-realidad',
    'title' => 'El sistema educativo de Finlandia: ¿mito o realidad?',
    'excerpt' => 'Verifico once afirmaciones populares sobre el sistema educativo de Finlandia con PISA 2025, la OCDE y fuentes oficiales finlandesas: qué es verdad, qué es exagerado y qué ya cambió. Y lo comparo con Colombia y América Latina para separar lo que se puede adaptar de lo que no.',
    'seo_title' => 'Sistema educativo de Finlandia: ¿mito o realidad?',
    'seo_description' => 'Verifico 11 creencias sobre el sistema educativo de Finlandia con PISA 2025 y fuentes oficiales, y lo comparo con Colombia y América Latina.',
    'focus_keyword' => 'sistema educativo de Finlandia',
    'cover' => '/assets/img/articulos/finlandia/finlandia-portada',
    'cover_alt' => 'Portada: El sistema educativo de Finlandia, ¿mito o realidad? Tarjeta con el puntaje de matemáticas en PISA: Finlandia 548 en 2006 y 469 en 2025, promedio OCDE 463 y Colombia 381 en 2025',
    'published_at' => '2026-10-09 16:00:00',
    'content_html' => <<<HTML
<p>En más de veinte años de docencia he escuchado hablar de Finlandia en casi todas las jornadas pedagógicas. Que allá no hay tareas ni notas, que los niños juegan hasta los siete años, que solo los mejores llegan a ser maestros y que por eso arrasan en las pruebas internacionales. Confieso que yo también lo repetí. Por eso, cuando la OCDE publicó los resultados de PISA 2025 el 8 de septiembre de 2026, decidí hacer lo que pido a mis estudiantes: ir a las fuentes y verificar.</p>
<p>Mi conclusión no es que Finlandia sea un mito, sino que <strong>el sistema educativo de Finlandia que circula en las redes ya no existe</strong>, y en algunos puntos nunca existió. Hay verdades sólidas, exageraciones, datos viejos y una caída en PISA que casi nadie menciona. Aquí reviso cada afirmación, la comparo con Colombia y América Latina y propongo qué podemos adaptar docentes, directivos y familias.</p>

<h2>La respuesta corta: ni milagro ni fraude</h2>
<p>Revisé once afirmaciones con documentos de la Agencia Nacional de Educación de Finlandia (OPH), del Ministerio de Educación y Cultura, de la legislación finlandesa, de la Universidad de Jyväskylä, que coordina PISA en ese país, y de la OCDE. Resultado: cuatro son ciertas, tres son verdades a medias, tres están desactualizadas y una es un mito.</p>
{$img('finlandia-mito-realidad', 839, 'Tabla de verificación de once afirmaciones sobre Finlandia. Verdad: almuerzo gratis desde 1948, admisión de cerca del 8 por ciento a la carrera de maestro en Helsinki, menos horas de clase y maestros valorados. Verdad a medias: todo gratis, entrada al colegio a los 7 años y gusto por la escuela. Desactualizado: sin notas ni exámenes, desplome de solicitudes y Finlandia en la cima de PISA. Mito: eliminaron las materias', 'Once afirmaciones verificadas. El detalle y las fuentes de cada una están más abajo.')}

<h2>La caída que casi nadie cuenta: Finlandia en PISA 2000–2025</h2>
<p>Finlandia encabezó la lectura en el primer PISA, en el año 2000, y durante una década fue la referencia obligada. Desde entonces ha bajado en todas las áreas y en todos los ciclos recientes. Según el {$ext($pisa25, 'informe PISA 2025 de la OCDE')} (volumen I, tabla I.1 y anexos de tendencia), estos son sus puntajes:</p>
<table>
<thead><tr><th>Área</th><th>Mejor año de Finlandia</th><th>2022</th><th>2025</th><th>Promedio OCDE 2025</th></tr></thead>
<tbody>
<tr><td>Lectura</td><td>547 (2006)</td><td>490</td><td><strong>474</strong></td><td>461</td></tr>
<tr><td>Matemáticas</td><td>548 (2006)</td><td>484</td><td><strong>469</strong></td><td>463</td></tr>
<tr><td>Ciencias</td><td>563 (2006)</td><td>511</td><td><strong>504</strong></td><td>482</td></tr>
</tbody>
</table>
{$img('finlandia-pisa-tendencia', 640, 'Gráfico de líneas de Finlandia en PISA de 2000 a 2025 frente al promedio de 23 países de la OCDE. Lectura baja de 547 en 2006 a 474 en 2025; matemáticas, de 548 a 469; ciencias, de 563 a 504. En matemáticas, Finlandia ya iguala al promedio OCDE comparable', 'En matemáticas, Finlandia perdió 79 puntos desde 2006 y hoy está en el nivel del promedio comparable de la OCDE.')}
<p>Finlandia sigue por encima del promedio de la OCDE en las tres áreas y ocupa el puesto 12 de 91 sistemas en ciencias, según {$ext('https://yle.fi/a/74-20245073', 'Yle')}. No es un sistema en crisis. Pero la tendencia es inequívoca y los detalles preocupan más que los promedios:</p>
<ul>
<li><strong>Más estudiantes rezagados.</strong> Los que no alcanzan el nivel básico en matemáticas pasaron de 6,8 % en 2003 a 24,9 % en 2022 y 31,0 % en 2025. En lectura, de 21,4 % a 25,8 % entre 2022 y 2025.</li>
<li><strong>Menos estudiantes sobresalientes.</strong> En matemáticas, los de nivel 5 o 6 bajaron de 23,4 % en 2003 a 6,7 % en 2025.</li>
<li><strong>Una brecha de género enorme en lectura.</strong> Las niñas superan a los niños por 46 puntos (498 frente a 452), una de las brechas más amplias del mundo; el promedio OCDE es 30.</li>
<li><strong>Una brecha migratoria que duplica la de la OCDE.</strong> En ciencias, los estudiantes sin origen migrante obtienen 517 y los de origen migrante 429: 88 puntos de diferencia, frente a 43 en la OCDE. Son cerca del 7 % de los evaluados, según el {$ext('https://www.jyu.fi/en/news/pisa-2025-students-in-finland-still-perform-well-above-oecd-average-in-science', 'informe nacional de la Universidad de Jyväskylä')}.</li>
<li><strong>La caída ya no es solo de los vulnerables.</strong> Entre 2022 y 2025, los estudiantes de familias favorecidas bajaron 12 puntos en ciencias y los desfavorecidos se mantuvieron. Las escuelas de habla sueca pasaron de 526 a 495 en ciencias.</li>
<li><strong>Menos perseverancia.</strong> Solo el 41 % de los estudiantes finlandeses dice esforzarse más cuando una tarea se vuelve difícil, la cifra más baja de todos los participantes.</li>
</ul>
<p>No es un caso aislado: según el prefacio de PISA 2025, el promedio OCDE cayó 22 puntos en matemáticas y 28 en lectura entre 2015 y 2025, y el deterioro empezó antes de la pandemia. Lo analicé para nuestra región en <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">las pruebas PISA en América Latina</a>. Lo distintivo de Finlandia es la magnitud: pocos países han perdido tanto desde su mejor momento.</p>

<h2>Verificación, afirmación por afirmación</h2>

<h3>"Todo es gratis, del preescolar a la universidad": verdad a medias</h3>
<p>La básica, la media y los materiales son gratuitos. Desde que la {$ext('https://eurydice.eacea.ec.europa.eu/news/finland-compulsory-education-extended-until-age-18', 'educación obligatoria se extendió hasta los 18 años')} el 1 de agosto de 2021, también lo son los materiales de la media. El {$ext('https://toolbox.finland.fi/wp-content/uploads/sites/2/2021/10/school-meals-a-finnish-succes-story-two-pager.pdf', 'almuerzo caliente gratuito')} existe desde 1948 y cubre preescolar, básica y media; la salud escolar y el transporte, cuando el trayecto supera 5 kilómetros, también son gratuitos.</p>
<p>Pero la educación inicial, la que reciben los niños antes del preescolar, <strong>no es gratuita</strong>: se cobra según los ingresos familiares, con un tope que desde el 1 de agosto de 2026 es de {$ext('https://www.pori.fi/app/uploads/sites/2/2026/05/varhaiskasvatusmaksut-1.8.2026.pdf', '335 euros al mes')} por el primer hijo. Y desde 2017 los estudiantes de fuera de la Unión Europea pagan matrícula en los programas universitarios en inglés, que en 2026 pasaron a cobrar el costo completo; en la Universidad de Turku, {$ext('https://www.utu.fi/en/news/press-release/university-of-turkus-international-degree-programmes-open-for-applications-on-7', 'entre 10.000 y 12.000 euros al año')}.</p>

<h3>"Entran al colegio a los 7 y antes solo juegan": verdad a medias</h3>
<p>La escolaridad obligatoria empieza el año en que el niño cumple 7, pero desde agosto de 2015 el {$ext('https://eurydice.eacea.ec.europa.eu/eurypedia/finland/access', 'preescolar es obligatorio a los 6')}, con al menos 700 horas al año. Y no es solo juego libre: se rige por un currículo nacional. Además, el 91,3 % de los niños de 3 a 5 años asiste a educación inicial.</p>
<p>Dato poco conocido: entre 2021 y 2024 Finlandia ensayó un preescolar de dos años en 148 municipios, con 37.357 niños. El {$ext('https://www.jyu.fi/fi/uutinen/kaksivuotisen-esiopetuksen-kokeilun-tulokset-julki', 'informe final')}, publicado el 14 de enero de 2026, encontró que los aprendizajes fueron iguales a los del modelo actual y que no se cerraron las brechas. A la fecha no hay decisión de hacerlo permanente.</p>

<h3>"No ponen notas numéricas ni hacen exámenes": desactualizado</h3>
<p>En 1.º a 3.º grado, cada municipio decide si la evaluación es descriptiva o numérica. Desde la reforma del currículo de 2020, los informes de fin de año de 4.º a 8.º grado y el certificado final deben llevar <strong>nota numérica</strong>, en escala de 4 a 10, según la {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/luku-6-oppilaan-oppimisen-ja-osaamisen-arviointi-perusopetuksessa', 'OPH')}. Desde 2021 existen criterios nacionales para la nota final de 9.º grado, y desde 2023 para la de 6.º.</p>
<p>Es cierto que no hay pruebas censales en la básica: el centro de evaluación Karvi mide muestras. Pero al final de la media existe el examen de bachillerato (<em>ylioppilastutkinto</em>), digital desde 2019, que desde 2020 pesa en la admisión universitaria. Y en junio de 2026 el Parlamento aprobó la {$ext('https://valtioneuvosto.fi/-/1410845/osaamistakuuta-koskeva-lainsaadanto-on-hyvaksytty-1', 'ley de garantía de competencias')} (619/2026), que fijará un nivel mínimo nacional para pasar de grado a partir de agosto de 2027. Finlandia va hacia más evaluación común, no menos.</p>
<p>La lección para nosotros no es "sin exámenes", sino "evaluar para aprender". Por eso diseñé el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>: crea quices cortos y varias versiones del mismo examen con su solucionario, para que evaluar con frecuencia no te cueste el fin de semana. Puedes probarlo gratis en la <a href="/examenes/demo/">demostración</a>.</p>

<h3>"Solo los mejores estudiantes llegan a ser maestros": verdad, con matices</h3>
<p>Desde 1979 los maestros de primaria deben tener <strong>maestría</strong>, según la {$ext('https://tuni.fi/en/news/teachers-must-also-have-time-learn', 'Universidad de Tampere')}. La selectividad es real: en 2025, el programa de formación de maestros de primaria de la Universidad de Helsinki recibió 1.532 aspirantes y admitió a 125, el 8,2 %, según las {$ext('https://www.helsinki.fi/assets/drupal/2025-09/Yhteishaussa%20kandiohjelmiin%20hakeneet,%20hyv%C3%A4ksytyt%20ja%20opiskelupaikan%20vastaanottaneet%20hakukohteittain%20ja%20tiedekunnittain%208.9.2025.pdf', 'cifras de la universidad')}. El examen de ingreso es nacional y desde 2025 se llama Valintakoe E, en reemplazo del antiguo VAKAVA.</p>
<p>¿Se desplomaron las solicitudes? Eso está desactualizado: la caída fuerte fue entre 2016 y 2019, de unos 6.500 a 5.300 aspirantes en todo el país, y en 2020 volvieron a superar los 6.000, según la {$ext('https://www.oph.fi/fi/uutiset/2020/opettajan-ammatti-kiinnostaa-yha-useampia-taydennys-ja-jatkokoulutusta-tarvitaan', 'OPH')}. En Helsinki, entre 2023 y 2025 la baja fue de alrededor del 8 %.</p>
<p>En Colombia la selección también es competida: al concurso de 2022 se presentaron 378.212 aspirantes a la prueba escrita para 37.480 vacantes, unos diez por plaza, según el {$ext('https://www.mineducacion.gov.co/portal/salaprensa/Comunicados/412272:Mas-de-378-mil-aspirantes-al-proceso-de-seleccion-Docentes-y-Directivos-Docentes-asistieron-a-la-jornada-de-pruebas-escritas-en-todo-el-pais', 'Ministerio de Educación')}. La diferencia es dónde se filtra: Finlandia selecciona al entrar a la carrera y luego confía; nosotros filtramos al final, con un examen, a personas que ya se formaron. Si te preparas para el próximo proceso, el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del concurso docente</a> te permite medirte, y aquí sigo <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el cronograma del nuevo concurso</a>.</p>

<h3>"Menos horas de clase y poca tarea": verdad</h3>
<p>Según la base de datos de {$ext('https://data-explorer.oecd.org/', 'Education at a Glance de la OCDE')}, un estudiante finlandés recibe 6.413 horas obligatorias de clase entre primaria y secundaria baja. El promedio OCDE es 7.604 y Colombia, 9.800: un 53 % más que Finlandia. En los grados 1 y 2 la jornada tiene como máximo cinco lecciones de 45 minutos, de acuerdo con la {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/tyoajat', 'OPH')}. En PISA 2012, los finlandeses reportaron menos de tres horas semanales de tareas, frente a casi cinco en la OCDE, según la {$ext('https://doi.org/10.1787/5jxrhqhtx2xt-en', 'OCDE')}.</p>
<p>Ojo: desde agosto de 2025 Finlandia {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/perusopetukseen-lisaa-aikaa-opiskella-aidinkielta-ja-kirjallisuutta-seka', 'añadió tres lecciones semanales')} de lengua materna y matemáticas en los primeros grados. Más horas no garantizan más aprendizaje, y Colombia es la prueba, pero en lectura y cálculo inicial a Finlandia le faltaba tiempo.</p>

<h3>"Eliminaron las materias y enseñan por fenómenos": mito</h3>
<p>En marzo de 2015 varios medios internacionales publicaron que Finlandia "eliminaría las asignaturas". No era cierto. El {$ext('https://www.oph.fi/sites/default/files/documents/perusopetuksen_opetussuunnitelman_perusteet_2014.pdf', 'currículo nacional de 2014')}, vigente desde 2016, exige al menos un <strong>módulo de aprendizaje multidisciplinario por año</strong>, organizado alrededor de un fenómeno o problema real. Las materias siguen existiendo, y Pasi Sahlberg, gran divulgador del modelo, {$ext('https://pasisahlberg.com/finlands-school-reforms-wont-scrap-subjects-altogether/', 'lo aclaró en su momento')}.</p>
<p>La idea, sin embargo, es aplicable: un proyecto al año que integre áreas y termine en un producto real cabe en cualquier colegio colombiano. Para eso armé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>: trae recetas por materia, alineadas con los estándares y los DBA, para planear unidades por proyectos e integrar áreas sin empezar de cero.</p>

<h3>"A los niños finlandeses les encanta la escuela": verdad a medias</h3>
<p>La Encuesta de Salud Escolar del instituto THL muestra un deterioro. En 8.º y 9.º grado, el gusto por la escuela bajó del 60 % en 2019 al 51 % en 2025, y en 4.º y 5.º, del 78 % al 70 %. El acoso escolar semanal en 8.º y 9.º subió del 5 % al 8 %; la {$ext('https://www.oph.fi/fi/uutiset/2025/kouluterveyskysely-2025-kouluissa-ja-oppilaitoksissa-rakennettava-yhteisollisyys-tukee', 'OPH')} reconoce que casi uno de cada diez estudiantes de básica sufre acoso cada semana. A favor: en PISA 2025 el sentido de pertenencia de los estudiantes siguió por encima del promedio OCDE.</p>

<h3>"Los maestros son muy valorados": verdad, pero en descenso</h3>
<p>En TALIS 2024, la encuesta internacional de docentes de la OCDE, el 48 % de los profesores finlandeses de secundaria siente que la sociedad valora su profesión, frente al 22 % del promedio OCDE, según el {$ext('https://jyx.jyu.fi/bitstreams/129367e8-54eb-47d6-9121-d888980ef468/download', 'informe nacional del Ministerio de Educación')}. Pero son 10 puntos menos que en 2018, y la satisfacción laboral bajó del 91 % en 2013 al 85 %. En Colombia, según el {$ext('https://www.icfes.gov.co/wp-content/uploads/2025/11/20251118_informe-Talis_19_11_25.pdf', 'informe del Icfes')} y la {$ext('https://fundacionexe.org.co/wp-content/uploads/2025/11/133_Talis_2024.pdf', 'Fundación Empresarios por la Educación')}, el 97 % de los docentes está satisfecho con su trabajo, más de la mitad se siente valorado por la sociedad y más del 90 % volvería a elegir la docencia.</p>

<h2>¿Por qué cayó Finlandia? El debate en casa</h2>
<p>No hay una sola explicación, y los investigadores finlandeses evitan las respuestas simples. Estas son las hipótesis con más respaldo:</p>
<ol>
<li><strong>Menos lectura por placer.</strong> En PISA 2018, el 63 % de los niños finlandeses decía leer solo cuando era obligatorio, según {$ext('https://yle.fi/a/3-11100956', 'Yle')}. Tras PISA 2025, el investigador Arto Ahonen señaló que la lectura en papel es cada vez menos común.</li>
<li><strong>Pantallas y teléfonos.</strong> Sahlberg ha advertido que los jóvenes pasan muchas horas frente a dispositivos, leen menos y duermen peor, y la OCDE asocia la caída en lectura con la digitalización y el tiempo de pantalla.</li>
<li><strong>Recortes municipales.</strong> Tras la crisis de 2008, muchos municipios cerraron o fusionaron escuelas, agrandaron grupos y redujeron personal de apoyo, según Sahlberg en una {$ext('https://gulfnews.com/lifestyle/why-finlands-schools-seem-to-be-slipping-1.1953014', 'columna para The Washington Post')}.</li>
<li><strong>Inclusión sin recursos suficientes.</strong> La directora de la OPH, Minna Kelha, escribió en 2023 que "la inclusión no debe usarse como excusa para ahorrar dinero" y que los recursos no llegaban a todas partes ({$ext('https://www.oph.fi/en/blog/pisa-results-reflect-broader-changes-finnish-society', 'OPH')}). Hoy faltan educadores especiales: en Pori, 11 de 18 plazas estaban sin cubrir en marzo de 2026, según {$ext('https://yle.fi/a/74-20215258', 'Yle')}.</li>
<li><strong>Migración: un factor real, pero menor.</strong> Los estudiantes de origen migrante son cerca del 7 % de los evaluados, y la brecha se redujo en parte porque bajaron más los estudiantes nativos, así que no explica la caída general, según la {$ext('https://www.jyu.fi/fi/uutinen/maahanmuuttajataustaisten-nuorten-osaaminen-pisa-2022-tutkimuksessa', 'Universidad de Jyväskylä')}.</li>
<li><strong>Los críticos del relato.</strong> Tim Oates, de Cambridge Assessment, sostiene que Finlandia "tocó techo en 2000" y que dejó de hacer lo que la llevó al éxito ({$ext('https://cambridgeassessment.org.uk/blogs/finland-old-stories-new-headlines', 'Cambridge Assessment')}). Gabriel Heller Sahlgren, en <em>Real Finnish Lessons</em> (2015), argumenta que el éxito vino de una cultura escolar tradicional y disciplinada anterior a las reformas, y que su erosión explica la caída ({$ext('https://www.ifn.se/en/news/2011-2015/2015-04-15-modern-school-policy-did-not-create-the-finnish-miracle', 'IFN')}).</li>
</ol>
<p>Hay una hipótesis que circula mucho y que no pude respaldar con datos: que el currículo de 2016 causó la caída. La tendencia empezó años antes de que entrara en vigor, así que, como mínimo, no es la causa principal.</p>

<h2>Cómo está respondiendo Finlandia</h2>
<p>Lo más interesante de la Finlandia actual no es su leyenda, sino su reacción:</p>
<ul>
<li><strong>Restricción de celulares.</strong> La ley {$ext('https://www.finlex.fi/fi/lainsaadanto/saadoskokoelma/2025/245', '245/2025')}, vigente desde el 1 de agosto de 2025, prohíbe usar el teléfono durante las clases salvo permiso del docente para aprender o por razones de salud. Lo analicé en <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">celulares en el colegio: ¿prohibir o enseñar?</a></li>
<li><strong>Reforma del apoyo al aprendizaje.</strong> Desde agosto de 2025 la ley 1090/2024 reemplazó el modelo de apoyo en tres niveles por apoyos más grupales y con más recursos, unos 100 millones de euros adicionales según {$ext('https://yle.fi/a/74-20149497', 'Yle')}.</li>
<li><strong>Más lectura y más horas.</strong> Tres lecciones semanales más en los primeros grados y un {$ext('https://www.oph.fi/fi/teemat-ja-kehittaminen/lukutaito-ohjelma', 'programa nacional de alfabetización')} de la OPH.</li>
<li><strong>Mínimos nacionales.</strong> La ley de garantía de competencias, desde 2027, con criterios comunes para pasar de grado.</li>
</ul>
<p>El símbolo mundial de la autonomía está agregando reglas, tiempo y medición. No lo leo como un fracaso, sino como lo primero que deberíamos imitar: mirarse con honestidad y corregir.</p>

<h2>Finlandia, Colombia y América Latina en cifras</h2>
<p>Comparar sin contexto lleva a conclusiones equivocadas. Reuní seis indicadores de la OCDE, con Chile y México como referencia latinoamericana porque tienen datos comparables en todos.</p>
{$img('finlandia-colombia-indicadores', 1084, 'Barras comparativas de Finlandia, Colombia, Chile y México con el promedio OCDE como línea de referencia. Gasto por estudiante: Finlandia 16.141 dólares PPA, Colombia 3.405. Salario docente inicial: Finlandia 50.227, Colombia 36.196. Horas de clase: Finlandia 6.413, Colombia 9.800. Matrícula a los 3 años: Finlandia 87,4 por ciento, Colombia 55,3. Estudiantes por docente en primaria: Finlandia 12, Colombia 22,2. PISA 2025 matemáticas: Finlandia 469, Colombia 381', 'Finlandia gasta casi cinco veces más por estudiante que Colombia, con menos horas, grupos más pequeños y más educación inicial.')}
<table>
<thead><tr><th>Indicador</th><th>Finlandia</th><th>Colombia</th><th>Promedio OCDE</th></tr></thead>
<tbody>
<tr><td>Gasto por estudiante, primaria a universidad (USD PPA, 2023)</td><td>16.141</td><td>3.405*</td><td>15.897</td></tr>
<tr><td>Gasto en instituciones educativas (% del PIB, 2023)</td><td>5,4 %</td><td>3,5 %*</td><td>4,7 %</td></tr>
<tr><td>Horas obligatorias, primaria y secundaria baja (2025)</td><td>6.413</td><td>9.800</td><td>7.604</td></tr>
<tr><td>Tamaño promedio de grupo en secundaria baja (2024)</td><td>19,4</td><td>27,5</td><td>22,8</td></tr>
<tr><td>Niños de 3 años en educación inicial (2024)</td><td>87,4 %</td><td>55,3 %</td><td>81,5 %</td></tr>
<tr><td>PISA 2025: matemáticas, lectura y ciencias</td><td>469 / 474 / 504</td><td>381 / 399 / 414</td><td>463 / 461 / 482</td></tr>
</tbody>
</table>
<p><small>* La OCDE marca que el dato de Colombia excluye instituciones privadas independientes; es, en la práctica, gasto público y debe leerse como un piso. Fuentes: base de datos de Education at a Glance (actualizada en julio de 2026) y PISA 2025.</small></p>
<p>Dos datos merecen comentario. El salario inicial de un docente colombiano de secundaria es el 72 % del finlandés, y la OCDE calcula que, con 15 años de experiencia, equivale a 2,11 veces lo que gana un profesional colombiano promedio, frente a 0,79 en Finlandia. No significa que aquí se pague bien a los maestros, sino que los profesionales en general ganan poco. Y el promedio simple de los 13 países latinoamericanos en PISA 2025 fue 370 en matemáticas, 389 en lectura y 399 en ciencias. Colombia, con 381, 399 y 414, queda algo por encima del promedio regional, pero muy lejos de la OCDE.</p>

<h2>Qué se puede trasladar a Colombia y qué no</h2>

<h3>Lo que no se importa con un decreto</h3>
<ul>
<li><strong>La confianza social.</strong> En Finlandia los padres no revisan cada nota porque confían en el maestro, y el maestro trabaja sin inspección constante porque confía en su formación. Esa confianza se construyó durante décadas y es efecto tanto como causa de los buenos resultados.</li>
<li><strong>El Estado de bienestar.</strong> Un niño finlandés llega al aula con salud, alimentación y vivienda razonablemente resueltas. En Colombia el Programa de Alimentación Escolar alcanzó el 85,5 % de cobertura en 2026, según {$ext('https://radionacional.co/actualidad/educacion/programa-de-alimentacion-escolar-llego-al-855-de-cobertura-en-2026', 'Radio Nacional')}, y la Contraloría advirtió que faltaban 1,3 billones de pesos para no dejar por fuera a 1,6 millones de estudiantes ({$ext('https://www.elespectador.com/educacion/contraloria-advierte-que-faltan-13-billones-para-financiar-el-pae-de-2026/', 'El Espectador')}). Finlandia lo resolvió en 1948.</li>
<li><strong>El gasto.</strong> Con poco más de un tercio del gasto por estudiante de Chile y una quinta parte del finlandés, pedirle a la escuela colombiana resultados nórdicos es una injusticia.</li>
</ul>

<h3>Lo que sí podemos adaptar</h3>
<ul>
<li><strong>Educación inicial de calidad.</strong> La cobertura neta de transición en Colombia fue de 57,5 % en 2025, según la {$ext('https://www.mineducacion.gov.co/portal/anos/2026/350799:Informacion-Cobertura-en-cifras-2025', 'información de cobertura del Ministerio de Educación')}, aunque ese cálculo depende de las proyecciones de población del DANE. La atención integral a la primera infancia llegó a unos 2,06 millones de niños en 2025. Es la apuesta con mejor retorno, y Finlandia nos recuerda que la calidad importa más que los años: su ensayo de dos años de preescolar no mejoró los aprendizajes.</li>
<li><strong>Apoyo temprano dentro del aula.</strong> La fortaleza histórica finlandesa fue detectar dificultades a tiempo y dar apoyo especializado sin esperar un diagnóstico. Colombia tiene una norma avanzada, el Decreto 1421 de 2017 y el PIAR, y unos 217.000 estudiantes con discapacidad matriculados en 2025, pero pocos docentes de apoyo. Lo analicé en <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusión en el aula: PIAR en Colombia, América Latina y el mundo</a>, y para aliviar la parte documental creé <a href="/herramientas/piar/">PIAR con IA</a>, que te da el primer plan gratis.</li>
<li><strong>Autonomía con responsabilidad.</strong> La autonomía finlandesa nunca fue ausencia de reglas: hay currículo nacional, criterios de evaluación y ahora mínimos de competencias. Lo adaptable es dar margen al docente para decidir cómo enseñar, a cambio de acuerdos claros sobre qué deben aprender los estudiantes.</li>
<li><strong>Equidad en la financiación.</strong> Colombia no puede pagar grupos finlandeses en todas partes, pero sí priorizar los primeros grados y las sedes rurales, donde cada estudiante adicional por grupo pesa más.</li>
</ul>

<h2>Lo que esto significa para docentes, directivos y familias</h2>
<p><strong>Si eres docente</strong>, la lección más útil de Finlandia no es una técnica, sino una prioridad: lectura sostenida desde los primeros grados, evaluación frecuente y sin dramatismo y apoyo temprano al que se queda atrás. Y la perseverancia también se enseña: pedir que sigan intentando cuando un problema se pone difícil vale más que cualquier plataforma.</p>
<p><strong>Si eres directivo</strong>, protege el tiempo de lectura, organiza el apoyo pedagógico como trabajo de equipo y no como trámite, y desconfía de las reformas importadas sin recursos: Finlandia aprendió que la inclusión sin personal de apoyo se vuelve sobrecarga.</p>
<p><strong>Si eres padre o madre</strong>, no esperes que el colegio de tu hijo "sea como Finlandia": espera que lea todos los días, que le enseñen a perseverar y que alguien note pronto si se está quedando atrás. Y en casa, la lectura por gusto y los límites a las pantallas hacen más que cualquier tarea adicional.</p>
<p>Si quieres ver cómo quedan otros países que suelen ponerse de ejemplo, como Estonia, Japón o Singapur, te recomiendo mi análisis de <a href="/mejores-sistemas-educativos-del-mundo-colombia/">los mejores sistemas educativos del mundo y qué puede aprender Colombia</a>.</p>

<p class="notice"><strong>Lo mejor de Finlandia, adaptado a tu aula.</strong> El <strong>Kit de IA para docentes</strong> te ayuda a planear proyectos y unidades interdisciplinarias alineadas con los estándares colombianos, por 60.000 pesos cada materia. El <strong>Generador de exámenes con IA</strong> crea evaluaciones formativas en varias versiones, con planes desde 29.900 pesos. <strong>PIAR con IA</strong> te deja hacer el primer PIAR gratis y luego elegir paquetes de 5, 10 o 20 planes. Y si te preparas para el concurso, el <a href="/herramientas/simulacro-concurso-docente/">simulacro docente</a> es gratuito. Ninguna reemplaza tu criterio: están hechas para darte tiempo para lo que importa.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Preguntas frecuentes</h2>
<h3>¿El sistema educativo de Finlandia sigue siendo el mejor del mundo?</h3>
<p>No según PISA. En 2025 Finlandia obtuvo 504 en ciencias, 474 en lectura y 469 en matemáticas, por encima del promedio OCDE pero lejos de Singapur, Japón, Corea, Estonia o las regiones chinas que encabezan la prueba. Es un sistema equitativo y de buen nivel, pero ya no el líder.</p>
<h3>¿Cuánto ha bajado Finlandia en PISA?</h3>
<p>Desde 2006, su mejor año, perdió 79 puntos en matemáticas (de 548 a 469), 73 en lectura (de 547 a 474) y 59 en ciencias (de 563 a 504). Entre 2022 y 2025 bajó 15 puntos en matemáticas y 16 en lectura.</p>
<h3>¿A qué edad entran los niños al colegio en Finlandia?</h3>
<p>La escolaridad obligatoria empieza el año en que cumplen 7, pero desde 2015 el preescolar es obligatorio a los 6, y más del 90 % de los niños de 3 a 5 años asiste a educación inicial. Desde 2021 la educación es obligatoria hasta los 18.</p>
<h3>¿Es verdad que en Finlandia no hay notas ni exámenes?</h3>
<p>No. De 4.º a 8.º grado los informes de fin de año llevan nota numérica de 4 a 10, hay criterios nacionales para las notas de 6.º y 9.º, y al terminar la media existe un examen nacional de bachillerato. Lo que no hay son pruebas censales en la básica, aunque una ley de 2026 fijará mínimos nacionales desde 2027.</p>
<h3>¿Qué puede aprender Colombia del sistema educativo de Finlandia?</h3>
<p>Lo más trasladable es invertir en educación inicial de calidad, detectar y apoyar pronto a quien se queda atrás, seleccionar y formar bien a los docentes, evaluar para aprender y dar autonomía con acuerdos claros. Lo que no se copia por decreto es la confianza social y el Estado de bienestar que la sostienen.</p>

<h2>Para pensar</h2>
<p>Finlandia construyó su prestigio sobre una idea: confiar en los maestros en lugar de medirlos a cada rato. Hoy, después de casi veinte años de caída, aprobó una ley para fijar mínimos nacionales y añadió horas, reglas y evaluación común. Colombia, en cambio, mide mucho y confía poco. <strong>Si el país que más confiaba en sus maestros empieza a medir más, ¿será que la confianza fue un premio a los buenos resultados y no su causa? Y si es así, ¿qué estaríamos dispuestos a ceder los colombianos, en control, en pruebas o en desconfianza, para darles a nuestros maestros esa confianza antes de que los resultados la justifiquen?</strong></p>
HTML,
];
