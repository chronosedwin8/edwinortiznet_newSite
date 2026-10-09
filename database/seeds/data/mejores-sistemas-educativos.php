<?php

declare(strict_types=1);

// Análisis con datos: los mejores sistemas educativos del mundo (Singapur, China, Japón, Corea, Estonia, Finlandia) frente a
// Colombia y América Latina, con PISA 2025, Education at a Glance 2026 y TALIS 2024, y una lista de chequeo para Colombia.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/mejores-sistemas/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'slug' => 'mejores-sistemas-educativos-del-mundo-colombia',
    'title' => 'Los mejores sistemas educativos del mundo: qué hicieron y qué le falta a Colombia',
    'excerpt' => 'Comparo a Singapur, China, Japón, Corea del Sur, Estonia y Finlandia con Colombia y América Latina usando PISA 2025, Education at a Glance 2026 y TALIS 2024. Explico cómo llegaron arriba, qué no se puede copiar y cierro con una lista de chequeo para Colombia: dónde estamos, qué falta y quién tiene que hacer qué.',
    'seo_title' => 'Mejores sistemas educativos del mundo vs. Colombia',
    'seo_description' => 'Singapur, China, Japón, Corea, Estonia y Finlandia frente a Colombia con PISA 2025: cómo llegaron arriba, qué no copiar y una lista de chequeo.',
    'focus_keyword' => 'mejores sistemas educativos del mundo',
    'cover' => '/assets/img/articulos/mejores-sistemas/mejores-sistemas-portada',
    'cover_alt' => 'Portada: Los mejores sistemas educativos del mundo y lo que le falta a Colombia. Tarjeta con el puntaje de matemáticas en PISA 2025: China (B-S-J-Z) 612, Singapur 563, Estonia 508, promedio OCDE 463 y Colombia 381',
    'published_at' => '2026-10-09 14:00:00',
    'content_html' => <<<HTML
<p>Cada vez que salen los resultados de PISA se repite la misma escena: titulares sobre Singapur y China en la cima, un párrafo sobre Finlandia, una línea triste sobre Colombia y, a la semana, el tema desaparece. Llevo más de veinte años enseñando matemáticas y tecnología en colegios colombianos y ya no me alcanza con el titular. Quiero entender <strong>qué hicieron los mejores sistemas educativos del mundo, cuánto de eso depende de la plata, cuánto de la cultura y cuánto de decisiones que Colombia también podría tomar</strong>.</p>
<p>El 8 de septiembre de 2026 la OCDE publicó los {$ext('https://www.oecd.org/en/publications/2026/09/pisa-2025-results-volume-i_5265bfb1.html', 'resultados de PISA 2025')}: 91 países y economías, más de 760.000 estudiantes de 15 años y el promedio de la OCDE más bajo de la historia de la prueba en las tres áreas. Con esos datos, {$ext('https://data-explorer.oecd.org/', 'Education at a Glance 2026')} y la encuesta docente TALIS 2024 armé esta comparación, que cierra con una lista de chequeo para Colombia.</p>

<h2>PISA 2025: quién está arriba y dónde está Colombia</h2>
<p>Los sistemas asiáticos dominan otra vez. En matemáticas, la muestra china de Pekín, Shanghái, Jiangsu y Zhejiang (B-S-J-Z) obtuvo 612 puntos, Singapur 563, Macao 549, Taipéi Chino 546, Japón 525 y Corea del Sur y Hong Kong 522. Estonia, el mejor de Europa, sacó 508. Finlandia, que durante años fue el modelo, bajó a 469, apenas seis puntos sobre el promedio de la OCDE (463).</p>
<p>Colombia obtuvo <strong>381 en matemáticas, 399 en lectura y 414 en ciencias</strong>, según la {$ext('https://www.oecd.org/en/publications/pisa-2025-results-volume-i-country-notes_2d4ff9ea-en/colombia_d64a60a2-en.html', 'nota de país de la OCDE')}. Frente a 2022 los cambios no son estadísticamente significativos (−2, −9 y +3), pero la caída en matemáticas y lectura desde 2018 sí lo es. En la región nos superan Uruguay, Chile, México, Costa Rica y Perú.</p>
<table>
<thead><tr><th>Sistema</th><th>Matemáticas</th><th>Lectura</th><th>Ciencias</th></tr></thead>
<tbody>
<tr><td>China (B-S-J-Z)</td><td>612</td><td>527</td><td>597</td></tr>
<tr><td>Singapur</td><td>563</td><td>535</td><td>560</td></tr>
<tr><td>Japón</td><td>525</td><td>503</td><td>538</td></tr>
<tr><td>Corea del Sur</td><td>522</td><td>501</td><td>526</td></tr>
<tr><td>Estonia</td><td>508</td><td>499</td><td>527</td></tr>
<tr><td>Finlandia</td><td>469</td><td>474</td><td>504</td></tr>
<tr><td><strong>Promedio OCDE</strong></td><td>463</td><td>461</td><td>482</td></tr>
<tr><td>Chile</td><td>403</td><td>436</td><td>442</td></tr>
<tr><td>México</td><td>388</td><td>408</td><td>414</td></tr>
<tr><td><strong>Colombia</strong></td><td><strong>381</strong></td><td><strong>399</strong></td><td><strong>414</strong></td></tr>
<tr><td>Brasil</td><td>377</td><td>408</td><td>409</td></tr>
</tbody>
</table>
{$img('mejores-sistemas-pisa-2025', 952, 'Gráfico de puntos con los puntajes de PISA 2025 en matemáticas, lectura y ciencias. Arriba, China (B-S-J-Z) con 612 en matemáticas, Singapur 563, Macao 549, Taipéi Chino 546, Japón 525, Hong Kong y Corea del Sur 522, Estonia 508 y Finlandia 469. Promedio OCDE: 463. Abajo, Uruguay 405, Chile 403, México 388, Costa Rica 387, Perú 382, Colombia 381, Brasil 377, Argentina 367, El Salvador 346, República Dominicana 339, Guatemala y Paraguay 334', 'PISA 2025: entre la muestra china y Colombia hay 231 puntos en matemáticas. En PISA, unos 20 puntos equivalen aproximadamente a un año escolar.')}
<p>PISA 2022 mostró el mismo orden: Singapur 575, Japón 536, Corea 527, Estonia 510, Finlandia 484 y Colombia 383, según el {$ext('https://www.oecd.org/content/dam/oecd/en/publications/reports/2023/12/pisa-2022-results-volume-i_76772a36/53f23881-en.pdf', 'volumen I de PISA 2022')}; en 2018 la muestra china había sacado 591. Es una tendencia, no un golpe de suerte.</p>

<h2>Más allá del promedio: cuántos se quedan atrás y cuántos sobresalen</h2>
<p>El promedio esconde lo más importante. PISA define el nivel 2 como el mínimo para usar las matemáticas en situaciones sencillas de la vida diaria. En Colombia, <strong>el 71 % de los estudiantes de 15 años no llega a ese nivel</strong>. En Singapur es el 11,2 %; en Japón, el 16,1 %; en la OCDE, el 34,9 %. Y en el otro extremo, solo el 0,2 % de los colombianos alcanza los niveles 5 y 6, frente al 37,4 % de Singapur y el 54,2 % de la muestra china.</p>
{$img('mejores-sistemas-desempeno', 1008, 'Gráfico de barras divergentes de PISA 2025 en matemáticas. A la izquierda, el porcentaje de estudiantes bajo el nivel 2: China (B-S-J-Z) 3,6 por ciento, Singapur 11 por ciento, Japón 16 por ciento, promedio OCDE 35 por ciento, Chile 59 por ciento, Colombia 71 por ciento y Guatemala 92 por ciento. A la derecha, el porcentaje en los niveles 5 y 6: China 54 por ciento, Singapur 37 por ciento, OCDE 7,8 por ciento y Colombia 0,2 por ciento', 'En matemáticas, Colombia tiene casi siete veces más estudiantes rezagados que Singapur y casi ninguno en los niveles más altos.')}
<p>Peor todavía: el 43,9 % de los estudiantes colombianos está bajo el nivel 2 en las tres áreas a la vez (OCDE: 19,7 %). No es un problema de matemáticas; es un problema de base.</p>

<h2>La tendencia: quién mejora, quién se estanca y quién cae</h2>
<table>
<thead><tr><th>Matemáticas</th><th>2012</th><th>2018</th><th>2022</th><th>2025</th></tr></thead>
<tbody>
<tr><td>Singapur</td><td>574</td><td>569</td><td>575</td><td>563</td></tr>
<tr><td>Japón</td><td>536</td><td>527</td><td>536</td><td>525</td></tr>
<tr><td>Corea del Sur</td><td>554</td><td>526</td><td>527</td><td>522</td></tr>
<tr><td>Estonia</td><td>521</td><td>523</td><td>510</td><td>508</td></tr>
<tr><td>Finlandia</td><td>519</td><td>507</td><td>484</td><td>469</td></tr>
<tr><td>Promedio OCDE (35 países)</td><td>491</td><td>490</td><td>475</td><td>466</td></tr>
<tr><td>Chile</td><td>423</td><td>417</td><td>412</td><td>403</td></tr>
<tr><td><strong>Colombia</strong></td><td>377</td><td>391</td><td>383</td><td>381</td></tr>
</tbody>
</table>
<p>Tres lecturas. Primera: casi todos bajan, incluidos los mejores; la pandemia y los cambios en los hábitos de lectura y de uso de pantallas pesan en todas partes, como conté al analizar <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA en América Latina</a>. Segunda: Colombia sigue apenas cuatro puntos por encima de su puntaje de 2012 y perdió lo que había ganado hasta 2018. Tercera: Finlandia perdió 50 puntos en trece años, el equivalente aproximado a dos años y medio de escolaridad. Ningún sistema está a salvo.</p>

<h2>Cómo llegaron a la cima los mejores sistemas educativos del mundo</h2>
<h3>Singapur: un plan de Estado y una cantera de maestros</h3>
<p>Singapur se independizó en 1965 sin recursos naturales y decidió que su recurso sería la gente. Lo notable es la constancia: en 1997 el primer ministro Goh Chok Tong lanzó «Thinking Schools, Learning Nation»; en 2004 Lee Hsien Loong anunció «Teach Less, Learn More», que redujo contenidos para profundizar; en 2023 {$ext('https://www.moe.gov.sg/news/parliamentary-replies/20231003-effect-of-removing-mid-year-examinations', 'eliminó los exámenes de mitad de año')} y en 2024 acabó con la separación en vías «Express» y «Normal» en secundaria. Cada reforma corrige a la anterior, pero la dirección no cambia.</p>
<p>El corazón del sistema son los docentes. Hay una sola institución formadora, el National Institute of Education (NIE), y el Ministerio recluta aproximadamente del tercio superior de cada cohorte. La formación {$ext('https://www.moe.gov.sg/careers/become-teachers/pri-sec-jc-ci/postgraduate-diploma', 'la paga el Ministerio')} y el futuro docente se compromete a enseñar al menos tres años. En 2026 anunció alzas salariales de 2 % a 9 % para seguir compitiendo con el mercado. En TALIS 2024, el 71 % de los docentes de Singapur siente que la sociedad valora su profesión.</p>
<p>Dos matices: Singapur invierte apenas el {$ext('https://data.worldbank.org/indicator/SE.XPD.TOTL.GD.ZS?locations=SG', '2,19 % de su PIB en educación')} (2024), porque su PIB por habitante es altísimo: el gasto acumulado por estudiante supera los 166.000 dólares. Y es de los sistemas donde más pesa el origen social: entre el cuarto más rico y el más pobre hay 103 puntos en matemáticas, más que el promedio de la OCDE (83). El propio {$ext('https://www.moe.gov.sg/news/press-releases/20260908-pisa-2025-singapore-students-demonstrate-strong-real-world-problem-solving-skills-in-computational-thinking-domain', 'Ministerio de Educación')} reconoce que la brecha entre sus mejores y sus peores estudiantes se amplió.</p>

<h3>China, Hong Kong, Macao y Taipéi: excelencia con asterisco</h3>
<p>Los 612 puntos de China hay que leerlos con cuidado. La muestra B-S-J-Z cubre solo cuatro de las regiones más ricas del país; la propia OCDE advirtió en 2018 que «están lejos de representar a China en su conjunto», y equivalen a cerca del 13 % de su población. Es como si Colombia participara solo con Bogotá, Medellín, Bucaramanga y Tunja.</p>
<p>China también muestra los costos del modelo. En 2021 lanzó la política de la {$ext('https://www.wilmerhale.com/en/insights/client-alerts/20210823-china-releases-double-reduction-policy-in-education-sector', '«doble reducción»')}, que prohibió las academias con ánimo de lucro de materias escolares durante la educación obligatoria, para bajar la presión sobre las familias. Taipéi se mantuvo estable (547 en 2022 y 546 en 2025), mientras Hong Kong cayó 18 puntos en matemáticas y 20 en lectura. Macao, en cambio, es el caso más equitativo del grupo: allí el nivel socioeconómico explica apenas el 4,2 % de la variación en matemáticas, frente al 12 % en la OCDE y el 17 % en Colombia.</p>

<h3>Japón y Corea del Sur: rigor, prestigio y el precio de la presión</h3>
<p>Japón y Corea comparten una cultura que valora el estudio como deber familiar. En Corea, la formación de maestros de primaria recibe a estudiantes entre los mejores del examen nacional de ingreso, según el {$ext('https://www.mona.uwi.edu/cop/sites/default/files/resource/files/how-the-worlds-best-performing-school-systems-come-out-on-top-sept-072.pdf', 'informe McKinsey de 2007')}. Japón es famoso por el «estudio de clases» (<em>jugyō kenkyū</em>), en el que los docentes planean, observan y corrigen juntos una misma clase.</p>
<p>Pero hay un lado oscuro. En 2025 las familias coreanas gastaron {$ext('https://www.koreajoongangdaily.com/korea/private-education-spending-for-grade-school-students-hits-record-high-in-2025/12560246', '27,5 billones de wones en educación privada')} (academias o <em>hagwon</em>), con una participación del 75,7 % y un gasto récord de 604.000 wones al mes por estudiante inscrito; en 2024 habían sido 29,2 billones. Un estudio presentado en septiembre de 2026 en una conferencia del Banco de Corea estima que, sin esa competencia, la fecundidad sería un 28 % más alta, según {$ext('https://www.koreatimes.co.kr/southkorea/20260903/koreas-birthrate-could-have-been-28-higher-without-private-education-competition', 'The Korea Times')}, en un país que tuvo 0,72 hijos por mujer en 2023. Y, según las estadísticas oficiales reseñadas por la prensa coreana en mayo de 2026, el suicidio fue la primera causa de muerte de las personas de 9 a 24 años en 2024, por decimocuarto año consecutivo.</p>
<p>En Japón, una familia con un hijo en secundaria pública gasta en promedio cerca de 230.000 yenes al año en <em>juku</em> (academias), según la {$ext('https://www.mext.go.jp/content/20260116-mxt_chousa01-000039333_3.pdf', 'encuesta del Ministerio de Educación')}. Y sus docentes trabajan 53 horas semanales, una de las cifras más altas de TALIS 2024; solo el 49,3 % volvería a escoger la profesión. Parte de ese éxito se paga fuera del colegio, con dinero de las familias y con salud mental.</p>

<h3>Estonia: la equidad como estrategia</h3>
<p>Estonia prueba que no hace falta ser asiático ni muy rico para estar arriba. Tiene una escuela básica común de nueve años, sin separar por vías antes de los 16; apostó desde 1996 por lo digital con {$ext('https://www.educationestonia.org/tiger-leap/', '«Tiger Leap»')}, y da mucha autonomía a sus colegios. Según el {$ext('https://hm.ee/sites/default/files/documents/2026-09/PISA_2025_Estonia_results_summary_EN_0.pdf', 'Ministerio de Educación estonio')}, el 82,8 % de sus estudiantes alcanza al menos el nivel 2 en matemáticas, la cifra más alta de Europa.</p>
<p>Sus alertas también enseñan: la lectura cayó 24 puntos desde 2018 y la docencia envejece. El {$ext('https://www.oecd.org/en/publications/education-at-a-glance-2026_c0e523a9-en/estonia_1c115451-en.html', 'Education at a Glance 2026')} reporta que el 40 % de los profesores de secundaria tiene 55 años o más, y solo el 20,3 % de los docentes estonios siente que la sociedad valora su trabajo.</p>

<h3>Finlandia: confianza, equidad y una caída que obliga a revisar el mito</h3>
<p>Finlandia construyó su fama con docentes formados en maestría, mucha autonomía, poca evaluación estandarizada y gran equidad. La selección sigue siendo exigente: en 2025 la Universidad de Helsinki admitió solo al {$ext('https://www.helsinki.fi/assets/drupal/2025-09/Yhteishaussa%20kandiohjelmiin%20hakeneet%2C%20hyv%C3%A4ksytyt%20ja%20opiskelupaikan%20vastaanottaneet%20hakukohteittain%20ja%20tiedekunnittain%208.9.2025.pdf', '8,2 % de los aspirantes')} al programa de maestros de primaria. Pero su lectura pasó de 546 puntos en 2000 a 474 en 2025, y solo el 41 % de sus estudiantes dice esforzarse más cuando una tarea se pone difícil. Lo analizo a fondo en <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finlandia: ¿mito o realidad de su sistema educativo?</a></p>

<h2>¿Es cuestión de plata? Gasto por estudiante y resultados</h2>
<p>Sí y no. La OCDE encontró en PISA 2022 que, hasta unos 75.000 dólares acumulados por estudiante entre los 6 y los 15 años, más gasto se asocia con mejores resultados; por encima de ese umbral, mucho menos. Colombia gastaba 37.315 dólares, la mitad del umbral y poco más de un tercio del promedio de la OCDE (102.612). Solo Chile, Colombia, Grecia, Letonia, Lituania, México y Turquía estaban por debajo dentro de la OCDE.</p>
{$img('mejores-sistemas-gasto', 667, 'Gráfico de dispersión del gasto acumulado por estudiante de 6 a 15 años frente al puntaje de matemáticas en PISA 2022. Los sistemas de alto desempeño están arriba a la derecha: Singapur con 166 mil dólares y 575 puntos, Macao con 196 mil y 552, Japón con 101 mil y 536. Colombia está abajo a la izquierda con 37 mil dólares y 383 puntos; Perú gasta 25 mil y obtiene 391, Panamá gasta 63 mil y obtiene 357. Una línea marca el umbral de 75 mil dólares', 'Por debajo del umbral, la plata importa; pero Perú logra más que Colombia con menos y Panamá menos con más.')}
<p>Pero el dinero no lo explica todo: por encima del umbral, Japón logra mucho más que el promedio de la OCDE con un gasto parecido, y Finlandia gasta más que Japón con peores resultados.</p>
<p>Education at a Glance 2026 registra un gasto de 3.405 dólares por estudiante de primaria a superior (dato parcial, solo público), frente a 15.897 en la OCDE. La serie oficial del {$ext('https://portalsineb.mineducacion.gov.co/1782/articles-412165_Recursos_04_V2024.pdf', 'Ministerio de Educación')} ubica el gasto público en educación en 4,1 % del PIB en 2024. Y el {$ext('https://normograma.supersalud.gov.co/compilacion/docs/acto_legislativo_03_2024.htm', 'Acto Legislativo 03 de 2024')} sube el Sistema General de Participaciones hasta el 39,5 % de los ingresos corrientes de la Nación en doce años, pero ese reloj solo arranca cuando el Congreso apruebe la ley de competencias, que a octubre de 2026 sigue en trámite, según {$ext('https://www.larepublica.co/economia/asi-cambiaria-el-reparto-de-los-recursos-para-las-regiones-con-la-ley-de-competencias-4446815', 'La República')}. Más recursos sin reglas claras de uso pueden terminar en nómina y burocracia, no en aprendizaje.</p>

<h2>Docentes: selección, salario y prestigio</h2>
<p>Todos los sistemas de alto desempeño cuidan a sus docentes. Pero hay un mito que desmontar: Andreas Schleicher, director de Educación de la OCDE, mostró en 2025 que {$ext('https://oecdedutoday.com/do-top-performing-countries-recruit-their-teachers-from-among-top-graduates/', 'en ningún país los docentes están en el tercio superior')} de los adultos con educación superior en las pruebas de competencias. Lo que hacen bien es formar, acompañar y retener a los que entran.</p>
<p>Colombia tiene datos que sorprenden. En {$ext('https://www.icfes.gov.co/wp-content/uploads/2025/11/20251118_informe-Talis_19_11_25.pdf', 'TALIS 2024')}, el 54 % de nuestros docentes de secundaria siente que la sociedad valora su profesión, frente al 21,7 % en la OCDE; ocupamos el puesto 12 entre 56 sistemas. El 97 % está satisfecho con su trabajo y el 91,2 % volvería a ser docente. El 18,2 % tiene un mentor asignado, el doble del promedio OCDE. Pero el 24 % dice que el costo le impide formarse, frente al 11 % en la OCDE, según el {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf-132-2025-informe-docentes-segun-talis-2024', 'informe 132 del LEE de la Javeriana')}.</p>
<table>
<thead><tr><th>Indicador docente</th><th>Colombia</th><th>OCDE</th><th>Referente alto</th></tr></thead>
<tbody>
<tr><td>Siente que la sociedad valora su profesión (TALIS 2024)</td><td>54 %</td><td>21,7 %</td><td>Singapur 71 %</td></tr>
<tr><td>Salario inicial, secundaria baja (USD PPA, 2025)</td><td>36.196</td><td>49.514</td><td>Finlandia 50.227</td></tr>
<tr><td>Salario tope habitual (USD PPA, 2025)</td><td>66.011</td><td>77.862</td><td>Corea 116.446</td></tr>
<tr><td>Usó inteligencia artificial en el último año</td><td>52,8 %</td><td>36,3 %</td><td>Singapur 74,9 %</td></tr>
<tr><td>Horas semanales de trabajo / de clase</td><td>38,7 / 26,0</td><td>38,5 / 21,2</td><td>Singapur 46,8 / 17,6</td></tr>
</tbody>
</table>
<p>Ese último dato dice mucho: el docente de Singapur trabaja más horas que el colombiano, pero da muchas menos clases. El resto del tiempo planea, corrige, observa a colegas y se forma. En Colombia damos 26 horas de clase semanales y muchos planeamos en la noche. Sobre la selección, el concurso de 2022 tuvo 378.212 aspirantes presentando pruebas para 37.480 vacantes, unos diez por plaza, según el {$ext('https://www.mineducacion.gov.co/portal/salaprensa/Comunicados/412272:Mas-de-378-mil-aspirantes-al-proceso-de-seleccion-Docentes-y-Directivos-Docentes-asistieron-a-la-jornada-de-pruebas-escritas-en-todo-el-pais', 'Ministerio de Educación')}; el {$ext('https://www.mineducacion.gov.co/1780/w3-article-429273.html', 'próximo concurso')} ofrecerá más de 26.300 vacantes. El mérito existe; lo que falta es que la formación inicial y el acompañamiento estén a la altura del filtro.</p>
<p>Si te estás preparando, el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del concurso docente</a> te permite medirte con preguntas tipo prueba, a tu ritmo, y aquí está el <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">cronograma actualizado con inscripciones en 2027</a>.</p>

<h2>América Latina: el problema empieza mucho antes de los 15 años</h2>
<p>PISA mide a los 15 años, pero el rezago se forma antes. En la prueba ERCE 2019 de la UNESCO, el 49,2 % de los estudiantes de sexto grado de la región quedó en el nivel más bajo de matemáticas, y el {$ext('https://documents1.worldbank.org/curated/en/099443504042242867/pdf/IDU0e7871c270811504df009e620db34dfd8158b.pdf', 'Banco Mundial')} calcula que el 83 % no alcanzó el nivel mínimo. Antes de la pandemia, según el {$ext('https://data.worldbank.org/indicator/SE.LPV.PRIM?locations=CO', 'indicador del Banco Mundial')}, el 51,4 % de los niños colombianos de 10 años no podía leer y comprender un texto sencillo («pobreza de aprendizaje»); en la región, el {$ext('https://www.worldbank.org/en/programs/educacion-america-latina-caribe/literacy', 'Banco Mundial estima')} que esa cifra pudo llegar al 79 % después del cierre de escuelas. El {$ext('https://www.iadb.org/es/noticias/bid-y-banco-mundial-no-hay-tiempo-que-perder-para-abordar-la-crisis-de-aprendizaje-en', 'BID y el Banco Mundial')} resumieron en 2024 que tres de cada cuatro jóvenes de 15 años de la región no tienen habilidades básicas de matemáticas.</p>
<p>En Colombia, el {$ext('https://lee.javeriana.edu.co/w/lee-informe-140', 'informe 140 del LEE')} muestra que el promedio de Saber 11 subió a 255,8 en 2025, el segundo más alto desde 2014, pero la brecha entre colegios urbanos y rurales llegó a 26,7 puntos, la mayor registrada, y la distancia entre privados y oficiales fue de 27,5. Según el {$ext('https://www.dane.gov.co/files/operaciones/EDUC/bol-EDUC-2024.pdf', 'DANE')}, el 67,4 % de las sedes educativas son rurales, pero solo el 57,2 % de ellas tiene internet, frente al 95 % de las urbanas. Y de cada 100 niños que entraron a primero en 2013, solo 44 llegaron a once a tiempo, según datos del LEE reseñados por {$ext('https://www.eltiempo.com/vida/educacion/solo-44-de-cada-100-ninos-llegan-a-tiempo-a-grado-once-en-colombia-asi-queda-el-sistema-educativo-colombiano-de-cara-al-nuevo-gobierno-3576663', 'El Tiempo')}.</p>

<h2>Lo que no se puede (ni se debe) copiar</h2>
<ul>
<li><strong>PISA no mide todo:</strong> ni arte, ni ciudadanía, ni convivencia, ni felicidad.</li>
<li><strong>Las muestras importan.</strong> La de Colombia cubre al 75 % de los jóvenes de 15 años; el resto está fuera del colegio o rezagado, y probablemente sacaría menos. Ampliar la cobertura puede bajar el promedio un tiempo sin que eso sea un fracaso.</li>
<li><strong>La cultura no se importa por decreto.</strong> La presión familiar coreana produce resultados, pero también ansiedad, gasto privado y desigualdad.</li>
<li><strong>Los contextos son distintos.</strong> Singapur es una ciudad-Estado de seis millones de habitantes sin ruralidad dispersa ni conflicto armado; Colombia tiene más de nueve millones de estudiantes, muchos en veredas sin internet.</li>
<li><strong>La autonomía funciona con capacidad.</strong> Sin docentes bien formados y confianza social, la autonomía se vuelve abandono.</li>
</ul>
<p>Lo transferible son las decisiones de fondo: primera infancia, tiempo para que el docente prepare y aprenda, políticas sostenidas por décadas y evaluación para corregir, no para castigar.</p>

<h2>Las brechas de Colombia en una sola imagen</h2>
<p>Comparé a Colombia con el promedio de los sistemas de alto desempeño en siete dimensiones. Cada barra es el dato colombiano como porcentaje del referente: 100 es el mismo nivel.</p>
{$img('mejores-sistemas-brechas', 816, 'Gráfico de barras con siete dimensiones de Colombia como porcentaje del promedio de los sistemas de alto desempeño. Por debajo: gasto acumulado por estudiante 28, estudiantes con nivel mínimo en matemáticas 36, niños de 3 años matriculados 61, equidad socioeconómica 64 y salario inicial docente 85. Por encima: docentes que se sienten valorados 132 y horas oficiales de clase en primaria 146', 'Las mayores brechas de Colombia están en el gasto, los aprendizajes básicos, la primera infancia y la equidad, no en las horas oficiales ni en la valoración que sienten los docentes.')}
<p>La imagen desmiente dos creencias. Colombia no tiene menos horas de clase oficiales que los mejores: tiene muchas más, aunque en la práctica la jornada única cubría solo el 19,9 % de la matrícula oficial en 2023, según el {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf120-informe-jornada-unica-2025-vf-lee', 'informe 120 del LEE')}. Y nuestros docentes se sienten más valorados que los de Japón o Estonia. Las brechas grandes están en la plata por estudiante, la primera infancia, la equidad y los aprendizajes básicos.</p>

<h2>Lista de chequeo: cómo podría Colombia acercarse a los mejores</h2>
<p>Convención: ✅ avanzando, ⚠️ parcial, ❌ pendiente. Plazos: corto (1 a 2 años), mediano (3 a 6) y largo (más de 6).</p>
<table>
<thead><tr><th>Dimensión</th><th>Estado</th><th>Responsable principal</th><th>Plazo</th></tr></thead>
<tbody>
<tr><td>1. Visión de Estado de largo plazo</td><td>❌ Pendiente</td><td>Estado, Congreso, MEN</td><td>Corto para acordarla, largo para sostenerla</td></tr>
<tr><td>2. Primera infancia</td><td>❌ Pendiente</td><td>MEN, ICBF, secretarías</td><td>Mediano</td></tr>
<tr><td>3. Formación y selección docente</td><td>⚠️ Parcial</td><td>MEN, universidades, CNSC</td><td>Mediano</td></tr>
<tr><td>4. Tiempo docente para planear y aprender</td><td>⚠️ Parcial</td><td>MEN, secretarías, rectores</td><td>Mediano</td></tr>
<tr><td>5. Salario y carrera docente</td><td>⚠️ Parcial</td><td>Estado, MEN, Fecode</td><td>Largo</td></tr>
<tr><td>6. Prestigio social de la docencia</td><td>✅ Avanzando</td><td>Docentes, medios, familias</td><td>Continuo</td></tr>
<tr><td>7. Equidad rural y conectividad</td><td>❌ Pendiente</td><td>Estado, MinTIC, secretarías</td><td>Mediano</td></tr>
<tr><td>8. Jornada única de calidad</td><td>⚠️ Parcial</td><td>MEN, secretarías</td><td>Mediano</td></tr>
<tr><td>9. Currículo enfocado y evaluación formativa</td><td>⚠️ Parcial</td><td>MEN, ICFES, colegios, docentes</td><td>Corto</td></tr>
<tr><td>10. Inclusión con ajustes reales</td><td>⚠️ Parcial</td><td>Colegios, docentes, familias</td><td>Corto</td></tr>
<tr><td>11. Datos para alertas tempranas</td><td>⚠️ Parcial</td><td>Secretarías, colegios</td><td>Corto</td></tr>
<tr><td>12. Financiación estable y bien usada</td><td>⚠️ Parcial</td><td>Congreso, MinHacienda, MEN</td><td>Largo</td></tr>
<tr><td>13. Cultura del esfuerzo y alianza con las familias</td><td>⚠️ Parcial</td><td>Familias, colegios, docentes</td><td>Continuo</td></tr>
</tbody>
</table>

<h3>1. Visión de Estado de largo plazo ❌</h3>
<ul>
<li><strong>Evidencia:</strong> Singapur sostiene la misma dirección desde 1997; en Colombia, el Plan Nacional Decenal de Educación 2016–2026 termina este año sin haber sido el centro del debate.</li>
<li><strong>Qué falta y cómo:</strong> un nuevo plan con pocas metas medibles (lectura en tercero, matemáticas en noveno, matrícula a los 3 años), presupuesto atado a ellas e informe público anual, que sobreviva a los cambios de ministro.</li>
</ul>

<h3>2. Primera infancia ❌</h3>
<ul>
<li><strong>Evidencia:</strong> solo el 55 % de los niños de 3 años está matriculado (OCDE: 75 %; Corea: 96 %). La cobertura neta en transición fue de 61,2 % en 2024 y, según el {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf139-primera-infancia-cobertura-lee-2026', 'informe 139 del LEE')}, menos de cuatro de cada diez niños asisten a prejardín o jardín.</li>
<li><strong>Qué falta y cómo:</strong> prejardín y jardín oficiales en municipios pequeños y zonas rurales, con metas por municipio y docentes de preescolar especializados.</li>
</ul>

<h3>3. Formación y selección docente ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> el concurso es competido (unos diez aspirantes por plaza en 2022), pero la formación inicial es desigual y el 24 % de los docentes no se forma por costos.</li>
<li><strong>Qué falta y cómo:</strong> prácticas largas y acompañadas, como en Finlandia y Singapur; becas para buenos bachilleres que escojan la docencia; inducción con mentor para todo docente nuevo y formación continua gratuita.</li>
</ul>

<h3>4. Tiempo docente para planear y aprender ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> 26 horas semanales de clase en Colombia, 21,2 en la OCDE y 17,6 en Singapur.</li>
<li><strong>Qué falta y cómo:</strong> una hora semanal protegida para trabajar entre colegas, al estilo del estudio de clases japonés. Mientras llega, herramientas que liberen tiempo: el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia alineadas con los estándares y los DBA para planear guías y actividades en minutos.</li>
</ul>

<h3>5. Salario y carrera docente ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> salario inicial de 36.196 dólares PPA (OCDE: 49.514); el tope habitual se alcanza a los diez años. Conviven dos estatutos, el Decreto 2277 de 1979 y el Decreto Ley 1278 de 2002.</li>
<li><strong>Qué falta y cómo:</strong> una carrera que premie la buena enseñanza y el liderazgo pedagógico, acordada a largo plazo entre Gobierno y Fecode.</li>
</ul>

<h3>6. Prestigio social de la docencia ✅</h3>
<ul>
<li><strong>Evidencia:</strong> el 54 % de los docentes se siente valorado (OCDE: 21,7 %) y el 91,2 % volvería a escoger la profesión.</li>
<li><strong>Qué falta y cómo:</strong> convertir ese prestigio en atracción de jóvenes talentosos a las licenciaturas, visibilizando a quienes logran aprendizajes en contextos difíciles.</li>
</ul>

<h3>7. Equidad rural y conectividad ❌</h3>
<ul>
<li><strong>Evidencia:</strong> brecha urbano-rural récord de 26,7 puntos en Saber 11; internet en el 57,2 % de las sedes rurales frente al 95 % de las urbanas.</li>
<li><strong>Qué falta y cómo:</strong> recursos asignados por necesidad, incentivos reales para que los docentes se queden en lo rural y conectividad como servicio escolar básico.</li>
</ul>

<h3>8. Jornada única de calidad ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> 19,9 % de la matrícula oficial en 2023, con meta de 30 % para 2026.</li>
<li><strong>Qué falta y cómo:</strong> infraestructura, alimentación y uso pedagógico de las horas extra, evaluando su efecto en aprendizajes. Más horas de lo mismo no sirven.</li>
</ul>

<h3>9. Currículo enfocado y evaluación formativa ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> Singapur redujo contenidos y eliminó exámenes de mitad de año para ganar tiempo de aprendizaje.</li>
<li><strong>Qué falta y cómo:</strong> priorizar aprendizajes esenciales y evaluar seguido para retroalimentar. El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> crea versiones distintas del mismo examen con su solucionario; prueba la <a href="/examenes/demo/">demostración gratuita</a>.</li>
</ul>

<h3>10. Inclusión con ajustes reales ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> el marco normativo es avanzado (Decreto 1421 de 2017 y los PIAR), pero los docentes lo aplican con poco tiempo y poco apoyo.</li>
<li><strong>Qué falta y cómo:</strong> docentes de apoyo suficientes y planes que se usen en el aula. <a href="/herramientas/piar/">PIAR con IA</a> ayuda a construirlos con ajustes razonables, y el primero es gratis. Amplío el tema en <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusión en el aula</a>.</li>
</ul>

<h3>11. Datos para alertas tempranas ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> solo 44 de cada 100 niños llegan a once a tiempo; la deserción fue de 3,2 % en 2023, con 12,3 % en Vichada.</li>
<li><strong>Qué falta y cómo:</strong> registro diario de asistencia y revisión mensual por curso. Un <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">listado de asistencia en Excel</a> bien llevado ya funciona como alerta temprana.</li>
</ul>

<h3>12. Financiación estable y bien usada ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> gasto acumulado por estudiante en la mitad del umbral de la OCDE; reforma del SGP aprobada pero condicionada a la ley de competencias.</li>
<li><strong>Qué falta y cómo:</strong> aprobar esa ley y amarrar los nuevos recursos a primera infancia, ruralidad y formación docente, con transparencia por municipio.</li>
</ul>

<h3>13. Cultura del esfuerzo y alianza con las familias ⚠️</h3>
<ul>
<li><strong>Evidencia:</strong> en Asia la familia acompaña el estudio a diario; en Finlandia, la caída coincide con menos lectura y menos perseverancia.</li>
<li><strong>Qué falta y cómo:</strong> lectura en casa, límites al uso recreativo de pantallas y acuerdos sencillos entre familia y colegio, como los que propongo en <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">celulares en el colegio</a>.</li>
</ul>

<h2>Tres miradas: docentes, directivos y familias</h2>
<p><strong>Los docentes</strong> no necesitamos que nos comparen con Finlandia en cada foro; necesitamos tiempo, formación útil y grupos manejables. «Menos formatos y más tiempo para enseñar», me dicen muchos colegas, y TALIS les da la razón.</p>
<p><strong>Los directivos</strong> viven entre la presión por resultados y la escasez. Un rector que asigna mentores, protege una hora de trabajo entre colegas y usa los datos de asistencia para actuar a tiempo hace más por el aprendizaje que diez circulares.</p>
<p><strong>Las familias</strong> quieren hijos que aprendan y estén seguros. La lección asiática no es pagar academias, sino acompañar: leer juntos, preguntar qué aprendió hoy, respetar el tiempo de estudio.</p>
<p>Frente a América Latina, Colombia está en el pelotón del medio, detrás de Chile y Uruguay. Frente al mundo, la distancia es enorme. Ambas cosas son ciertas, y la segunda debería quitarnos el sueño.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuáles son los mejores sistemas educativos del mundo según PISA 2025?</h3>
<p>En matemáticas lideran la muestra china de Pekín, Shanghái, Jiangsu y Zhejiang (612), Singapur (563), Macao (549), Taipéi Chino (546), Japón (525), Hong Kong y Corea del Sur (522). En Europa, el mejor es Estonia (508). En lectura, el primero es Singapur.</p>
<h3>¿Cómo le fue a Colombia en PISA 2025?</h3>
<p>Obtuvo 381 en matemáticas, 399 en lectura y 414 en ciencias, por debajo de la OCDE (463, 461 y 482). El 71 % no alcanzó el nivel mínimo en matemáticas. Los cambios frente a 2022 no son estadísticamente significativos.</p>
<h3>¿Por qué Singapur es tan bueno en educación?</h3>
<p>Por una planificación de Estado sostenida desde los años noventa, una sola institución formadora de docentes, reclutamiento exigente con formación pagada, currículo enfocado y apoyo familiar. Su costo: mucha presión y una brecha socioeconómica mayor que la del promedio OCDE.</p>
<h3>¿Finlandia sigue siendo un modelo educativo?</h3>
<p>Sigue por encima del promedio de la OCDE y conserva buenas prácticas en formación docente y equidad, pero perdió 50 puntos en matemáticas entre 2012 y 2025. Hoy enseña tanto como advertencia que como receta.</p>
<h3>¿Qué necesita Colombia para mejorar en PISA?</h3>
<p>Ampliar la educación inicial, cerrar la brecha rural, dar a los docentes tiempo para planear y formarse, sostener la política educativa más allá de un gobierno, financiar mejor con reglas claras y fortalecer la evaluación formativa y la alianza con las familias.</p>

<p class="notice"><strong>Herramientas para hacer la diferencia desde tu aula.</strong> Los mejores sistemas educativos del mundo protegen el tiempo del docente para planear, evaluar bien e incluir a todos. El <strong>Kit de IA para docentes</strong> trae recetas por materia alineadas con el currículo colombiano, por 60.000 pesos cada materia. El <strong>Generador de exámenes con IA</strong> crea versiones distintas del mismo examen, con planes desde 29.900 pesos. <strong>PIAR con IA</strong> te deja hacer un PIAR gratis y luego elegir paquetes de 5, 10 o 20 planes. Y si vas para el concurso, el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito</a> te ayuda a medir dónde estás.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Para pensar</h2>
<p>Corea del Sur está entre los mejores del mundo en PISA y, al mismo tiempo, tiene una de las tasas de fecundidad más bajas del planeta, un gasto récord en academias y el suicidio como primera causa de muerte de sus jóvenes. Finlandia apostó por el bienestar y la confianza, y hoy ve caer sus resultados año tras año. Colombia tiene docentes que se sienten valorados y estudiantes que, en su mayoría, no alcanzan lo mínimo. <strong>Si pudiéramos escoger, ¿qué sistema preferiríamos para nuestros hijos: uno que los lleve a la cima de PISA a costa de su infancia, o uno más amable que los deje sin las herramientas para competir en el mundo? ¿Y por qué seguimos creyendo que hay que escoger entre las dos cosas?</strong></p>
HTML,
];
