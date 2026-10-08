<?php

declare(strict_types=1);

// Divulgación: «La computación cuántica: para qué sirve y cómo podría cambiar el mundo». Explicada para un
// estudiante de 15 años (monedas, dados, laberintos), con aplicaciones realistas frente a exageraciones, problemas,
// soluciones y el estado del arte verificado el 8 de octubre de 2026 (Google, IBM, Microsoft, Quantinuum, IonQ,
// China, Colombia y el mundo). Incluye código opcional en Python (NumPy y Qiskit 2.x, probado), glosario y mitos.
// El texto va en nowdoc; los bloques <pre><code> se escapan automáticamente y las figuras se insertan con {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/computacion-cuantica/' . $name;
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
<p>Cada año hago el mismo experimento en clase. Lanzo una moneda al aire y, mientras gira, pregunto: «¿Es cara o es sello?». Alguien siempre responde «todavía no es ninguna». Esa respuesta, que suena a chiste, es la puerta de entrada a una de las tecnologías más comentadas y peor explicadas de esta década: <strong>la computación cuántica</strong>.</p>
<p>En los titulares se lee que los computadores cuánticos «resuelven en minutos lo que tomaría millones de años», que van a curar el cáncer y que acabarán con todas las contraseñas. Algo es cierto, mucho es exagerado y casi nunca se explica por qué. Te lo cuento como se lo contaría a un estudiante de 15 años: con monedas, dados y laberintos, y con cada dato enlazado a su fuente. Al final, para los curiosos, dejo un primer programa cuántico.</p>

<h2>¿Qué es la computación cuántica?</h2>
<p>Es una forma de procesar información que usa las reglas de la <strong>física cuántica</strong>, la parte de la ciencia que describe cómo se comportan los átomos, los electrones y la luz. A esa escala, la naturaleza no funciona como en la vida diaria: una partícula puede estar en una mezcla de estados y dos partículas pueden quedar conectadas aunque estén lejos.</p>
<p>Un computador cuántico no es un computador normal más rápido. Es una máquina distinta que <strong>aprovecha esas reglas para resolver ciertos problemas</strong>, no todos, mejor que un computador clásico. Para ver un video o hacer una tarea, tu celular seguirá siendo mejor.</p>

<h2>Cómo funciona, explicado con monedas y dados</h2>
<h3>Bit y qubit: la moneda quieta y la moneda que gira</h3>
<p>Todo lo que hace tu celular se reduce a <strong>bits</strong>: interruptores que valen 0 o 1, como una moneda quieta que muestra cara o sello. Un <strong>qubit</strong> (bit cuántico) se parece a la moneda que gira: no es solo cara ni solo sello, sino una combinación de las dos, con cierta «inclinación» hacia cada lado. Esa inclinación, la <em>amplitud</em>, decide qué tan probable es cada resultado cuando la moneda cae.</p>
{{img:qubit}}
<h3>Superposición: muchas posibilidades a la vez, pero con letra pequeña</h3>
<p>A ese estado de «moneda girando» se le llama <strong>superposición</strong>. Con un qubit tienes dos posibilidades mezcladas; con dos, cuatro; con tres, ocho; con 300 qubits, más combinaciones que átomos en el universo observable. De ahí la famosa frase «prueba todas las respuestas al mismo tiempo». Es una media verdad: si pusieras todas las respuestas a girar y miraras, obtendrías <em>una</em> al azar, casi siempre equivocada. El truco viene después.</p>
<h3>Interferencia: el arte de cancelar caminos equivocados</h3>
<p>Imagina un laberinto recorrido por ondas, como las de una piedra en un estanque. Donde dos crestas se encuentran, la ola crece; donde una cresta encuentra un valle, se anulan. Un algoritmo cuántico es una coreografía diseñada para que los caminos hacia las respuestas equivocadas <strong>se cancelen</strong> y los caminos hacia la correcta <strong>se refuercen</strong>. IBM lo resume así: la <a href="https://www.ibm.com/think/topics/quantum-computing" target="_blank" rel="noopener">interferencia es el motor de la computación cuántica</a>. Por eso no basta con muchos qubits: hace falta un problema con la estructura adecuada y un algoritmo ingenioso.</p>
<h3>Entrelazamiento: dos dados conectados</h3>
<p>Ahora imagina dos dados mágicos. Le das uno a una amiga que viaja a Leticia y te quedas con el otro en Barranquilla. Cada uno, por separado, cae al azar. Pero cuando comparan, siempre coinciden. Eso, muy simplificado, es el <strong>entrelazamiento</strong>: dos qubits forman un solo sistema y sus resultados quedan correlacionados. Dos matices: no sirve para enviar mensajes más rápido que la luz, porque cada uno ve un resultado al azar y solo al comparar descubren la coincidencia; y no es que los dados «ya supieran» qué iban a mostrar. Los experimentos que lo demostraron recibieron el <a href="https://www.nobelprize.org/prizes/physics/2022/summary/" target="_blank" rel="noopener">Premio Nobel de Física de 2022</a>.</p>
{{img:ideas}}
<h3>Medición: la moneda cae</h3>
<p>Cuando medimos un qubit, la moneda deja de girar y cae en 0 o en 1. La superposición desaparece y nos quedamos con un único resultado. Por eso los computadores cuánticos repiten el cálculo miles de veces y miran qué resultados salen más, como quien lanza una moneda muchas veces para saber si está cargada.</p>
<h3>Decoherencia: la moneda que se cae sola</h3>
<p>El enemigo número uno es la <strong>decoherencia</strong>: cualquier vibración, calor o ruido eléctrico «toca» la moneda y la hace caer antes de tiempo. Por eso muchos computadores cuánticos viven en refrigeradores gigantes. Según IBM, sus procesadores necesitan temperaturas <a href="https://www.ibm.com/think/topics/quantum-computing" target="_blank" rel="noopener">unas cien veces más frías que un grado por encima del cero absoluto</a>, más frías que el espacio exterior. Los mejores qubits del chip Willow de Google conservan su información <a href="https://blog.google/technology/research/google-willow-quantum-chip/" target="_blank" rel="noopener">cerca de 100 microsegundos</a>: una diezmilésima de segundo.</p>
<p>Un dato bonito para el aula: el Nobel de Física de 2025 fue para John Clarke, Michel Devoret y John Martinis por demostrar, en 1984 y 1985, efectos cuánticos en <a href="https://www.nobelprize.org/prizes/physics/2025/summary/" target="_blank" rel="noopener">un circuito eléctrico que se puede sostener en la mano</a>. De ahí vienen los qubits superconductores de Google e IBM.</p>

<h2>¿Para qué sirve? Lo realista y lo exagerado</h2>
<p>Conviene separar lo que la ciencia respalda de lo que vende titulares. Esta es mi lectura, con sus fuentes:</p>
<ul>
<li><strong>Química y medicamentos (lo más prometedor).</strong> Las moléculas obedecen las leyes cuánticas, así que simularlas con una máquina cuántica es natural. Un estudio de 2017 mostró que un computador cuántico con corrección de errores podría estudiar la enzima que fija el nitrógeno del aire, clave para <a href="https://doi.org/10.1073/pnas.1619152114" target="_blank" rel="noopener">producir fertilizantes con menos energía</a>, algo que ningún supercomputador logra con exactitud. En 2025, Google usó su algoritmo <em>Quantum Echoes</em> para estudiar <a href="https://blog.google/technology/research/quantum-echoes-willow-verifiable-quantum-advantage/" target="_blank" rel="noopener">dos moléculas de 15 y 28 átomos</a>, con resultados que coincidieron con la resonancia magnética. Es un primer paso, no una medicina.</li>
<li><strong>Materiales y baterías.</strong> Por la misma razón, podría ayudar a diseñar baterías y catalizadores. BMW investiga <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">catalizadores para celdas de combustible</a> en la máquina Helios de Quantinuum. Es investigación, no un producto.</li>
<li><strong>Logística y optimización.</strong> Elegir la mejor ruta para 50 camiones parece ideal para «probar todo a la vez», pero no hay prueba de una ventaja grande. John Preskill, el físico que bautizó esta etapa como la era <a href="https://quantum-journal.org/papers/q-2018-08-06-79/" target="_blank" rel="noopener">NISQ (cuántica ruidosa de escala intermedia)</a>, advierte que no se sabe si superarán a los mejores métodos clásicos en optimización.</li>
<li><strong>Finanzas.</strong> JPMorganChase investiga en Helios <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">posibles usos en análisis financiero</a>. Un resultado concreto: en 2025, con Quantinuum, generaron <a href="https://www.nature.com/articles/s41586-025-08737-1" target="_blank" rel="noopener">números aleatorios certificados</a>, útiles para seguridad y sorteos. Lo de «predecir la bolsa» es pura fantasía.</li>
<li><strong>Criptografía (la amenaza real).</strong> En 1994, Peter Shor demostró que un computador cuántico grande podría romper el cifrado RSA de bancos y correos. En 2025, Craig Gidney, de Google, estimó que bastaría una máquina con <a href="https://arxiv.org/abs/2505.15917" target="_blank" rel="noopener">menos de un millón de qubits ruidosos funcionando menos de una semana</a>. Hoy ninguna se acerca, pero la cifra es veinte veces menor que la de su estimación de 2019.</li>
<li><strong>Inteligencia artificial.</strong> Se habla mucho de «IA cuántica», pero los algoritmos de aprendizaje automático cuántico suelen tener <a href="https://www.nature.com/articles/nphys3272" target="_blank" rel="noopener">letra pequeña</a>, como advirtió el informático Scott Aaronson: cargar millones de datos en qubits es lento y puede borrar la ventaja. Por ahora, la IA ayuda más a la cuántica que al revés.</li>
<li><strong>Clima.</strong> Los modelos climáticos manejan enormes cantidades de datos, justo donde los supercomputadores clásicos brillan. El aporte posible es indirecto: mejores catalizadores, fertilizantes o materiales para capturar carbono.</li>
</ul>
{{img:puede}}

<h2>Ventajas</h2>
<ul>
<li><strong>Velocidad en problemas específicos.</strong> En tareas diseñadas para mostrar su poder, la diferencia es enorme: Willow hizo en menos de cinco minutos un cálculo que, según Google, tomaría <a href="https://blog.google/technology/research/google-willow-quantum-chip/" target="_blank" rel="noopener">10 cuatrillones de años</a> (10<sup>25</sup>) a un supercomputador. La propia Google aclara que esa tarea no tiene aplicación práctica.</li>
<li><strong>Simula la naturaleza «en su idioma».</strong> Moléculas y materiales son sistemas cuánticos.</li>
<li><strong>Resultados verificables.</strong> Quantum Echoes corrió <a href="https://blog.google/technology/research/quantum-echoes-willow-verifiable-quantum-advantage/" target="_blank" rel="noopener">13.000 veces más rápido</a> que el mejor algoritmo clásico en un supercomputador, y otro equipo cuántico puede repetirlo para comprobarlo.</li>
</ul>

<h2>Desventajas</h2>
<ul>
<li><strong>Se equivocan mucho.</strong> En los mejores equipos comerciales, una operación entre dos qubits falla alrededor de 1 de cada 1.000 a 10.000 veces: IonQ reportó un récord de <a href="https://investors.ionq.com/news/news-details/2025/IonQ-Achieves-Landmark-Result-Setting-New-World-Record-in-Quantum-Computing-Performance/default.aspx" target="_blank" rel="noopener">99,99 % de fidelidad</a> en octubre de 2025.</li>
<li><strong>Son frágiles.</strong> Necesitan frío extremo, vacío o láseres de precisión.</li>
<li><strong>Sirven para poco, por ahora.</strong> No ejecutan WhatsApp ni Excel, solo problemas muy particulares.</li>
<li><strong>Son caros y escasos.</strong> Casi todos los usamos por internet, con minutos contados.</li>
</ul>

<h2>Problemas que vienen</h2>
<ol>
<li><strong>Errores y ruido.</strong> Un cálculo útil, como el de las enzimas o el cifrado, exige miles de millones de operaciones sin fallar. Estamos lejos.</li>
<li><strong>Frío extremo y energía.</strong> Escalar significa refrigeradores más grandes, más cables y más consumo.</li>
<li><strong>Escalabilidad.</strong> Pasar de cien qubits a un millón no es «fabricar más»: cada qubit trae más ruido y más cables.</li>
<li><strong>Costo.</strong> El computador cuántico que puso en operación la UCEVA en Tuluá costó cerca de <a href="https://www.mineducacion.gov.co/1780/w3-article-427345.html" target="_blank" rel="noopener">450 millones de pesos</a>; los de investigación de punta, como los de Google o IBM, son proyectos de una escala muy distinta.</li>
<li><strong>Seguridad: «cosechar ahora, descifrar después».</strong> Alguien puede copiar hoy datos cifrados (historias clínicas, secretos de Estado) y guardarlos hasta tener una máquina capaz de abrirlos. Si un dato debe seguir siendo secreto en veinte años, el problema ya empezó.</li>
<li><strong>Desigualdad tecnológica.</strong> Pocos países y empresas pueden construir estas máquinas. ¿Quién tendrá la ventaja primero?</li>
</ol>

<h2>Soluciones en camino</h2>
<ul>
<li><strong>Corrección de errores y qubits lógicos.</strong> Funciona como un grupo de amigos que vota: varios qubits físicos guardan juntos un <strong>qubit lógico</strong>, y si uno falla, los demás lo corrigen. En diciembre de 2024, Google mostró con Willow que, al pasar de cuadrículas de 3×3 a 5×5 y 7×7 qubits, <a href="https://www.nature.com/articles/s41586-024-08449-y" target="_blank" rel="noopener">el error se reducía a la mitad en cada paso</a>. Fue la primera vez que más qubits significaron menos errores. IBM planea para 2029 <a href="https://www.ibm.com/roadmaps/quantum/" target="_blank" rel="noopener">Starling, con 200 qubits lógicos y 100 millones de operaciones</a>.</li>
<li><strong>Criptografía poscuántica.</strong> La defensa no es otro computador cuántico, sino matemática nueva que corre en los equipos de siempre. El 13 de agosto de 2024, el NIST de Estados Unidos publicó tres estándares: <a href="https://www.nist.gov/news-events/news/2024/08/nist-releases-first-3-finalized-post-quantum-encryption-standards" target="_blank" rel="noopener">FIPS 203 (ML-KEM), FIPS 204 (ML-DSA) y FIPS 205 (SLH-DSA)</a>, y pidió empezar a migrar «de inmediato». En marzo de 2025 eligió <a href="https://www.nist.gov/news-events/news/2025/03/nist-selects-hqc-fifth-algorithm-post-quantum-encryption" target="_blank" rel="noopener">HQC como respaldo</a>, y propuso <a href="https://csrc.nist.gov/pubs/ir/8547/ipd" target="_blank" rel="noopener">dejar RSA en desuso desde 2030 y prohibirlo en 2035</a>. El Reino Unido fijó la misma meta: <a href="https://www.ncsc.gov.uk/guidance/pqc-migration-timelines" target="_blank" rel="noopener">migración completa en 2035</a>.</li>
<li><strong>Nuevas tecnologías de qubits.</strong> Hay carreras en paralelo: circuitos superconductores (Google, IBM, China), iones atrapados (Quantinuum, IonQ), átomos neutros, fotones y los qubits topológicos de Microsoft, en teoría más resistentes al ruido.</li>
</ul>

<h2>Dónde estamos: el avance a octubre de 2026</h2>
<p>Cada hito de esta línea de tiempo tiene su discusión:</p>
{{img:linea}}
<ul>
<li><strong>Google.</strong> En 2019, su chip Sycamore de 53 qubits reclamó la «supremacía cuántica» con un cálculo de <a href="https://www.nature.com/articles/s41586-019-1666-5" target="_blank" rel="noopener">200 segundos</a>; IBM respondió que un supercomputador podía hacerlo en <a href="https://www.ibm.com/quantum/blog/on-quantum-supremacy" target="_blank" rel="noopener">unos días, no en 10.000 años</a>. Luego llegaron Willow (2024) y Quantum Echoes (2025).</li>
<li><strong>IBM.</strong> En noviembre de 2025 presentó <a href="https://www.tomshardware.com/tech-industry/semiconductors/ibm-unveils-new-120-qubit-processor-and-software-stack" target="_blank" rel="noopener">Nighthawk, de 120 qubits, y Loon</a>, un chip de prueba para la corrección de errores. En julio de 2026 anunció, con la Universidad de Chicago, Algorithmiq y Qedma, <a href="https://spectrum.ieee.org/ibm-verifiable-quantum-advantage" target="_blank" rel="noopener">tres demostraciones de ventaja cuántica verificada</a>. Ojo: aún no tenían revisión por pares y varios expertos pidieron prudencia, aunque Dominik Hangleiter sostiene en un <a href="https://arxiv.org/abs/2603.09901" target="_blank" rel="noopener">ensayo de 2026</a> que la ventaja ya existe.</li>
<li><strong>Microsoft.</strong> En febrero de 2025 presentó <a href="https://azure.microsoft.com/en-us/blog/quantum/2025/02/19/microsoft-unveils-majorana-1-the-worlds-first-quantum-processor-powered-by-topological-qubits/" target="_blank" rel="noopener">Majorana 1</a>, con ocho qubits «topológicos». La revista Nature publicó el <a href="https://www.nature.com/articles/s41586-024-08445-2" target="_blank" rel="noopener">artículo asociado</a> con una nota editorial: los resultados no eran prueba de los modos de Majorana. En junio de 2026, el físico Henry Legg publicó en Nature una <a href="https://doi.org/10.1038/s41586-026-10567-8" target="_blank" rel="noopener">crítica formal</a>, Microsoft <a href="https://doi.org/10.1038/s41586-026-10568-7" target="_blank" rel="noopener">respondió</a> y anunció Majorana 2. El <a href="https://www.theregister.com/a/5260489" target="_blank" rel="noopener">debate sigue abierto</a>.</li>
<li><strong>Quantinuum e IonQ.</strong> En noviembre de 2025 llegó <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">Helios, con 98 qubits</a> de iones atrapados; IonQ, con la misma tecnología, tiene el récord de fidelidad.</li>
<li><strong>China.</strong> El equipo de Pan Jianwei presentó Zuchongzhi 3.0, de 105 qubits superconductores, en <a href="https://journals.aps.org/prl/abstract/10.1103/PhysRevLett.134.090601" target="_blank" rel="noopener">Physical Review Letters</a> en marzo de 2025, y antes la máquina fotónica <a href="https://doi.org/10.1126/science.abe8770" target="_blank" rel="noopener">Jiuzhang</a> en 2020.</li>
</ul>
<h3>El mundo: un año dedicado a la cuántica</h3>
<p>La ONU proclamó 2025 como el <a href="https://quantum2025.org/" target="_blank" rel="noopener">Año Internacional de la Ciencia y la Tecnología Cuánticas</a>, a cien años de la mecánica cuántica, por iniciativa de México. Los gobiernos invierten: el Reino Unido comprometió <a href="https://uknqt.ukri.org/news/uk-government-publishes-the-national-quantum-strategy/" target="_blank" rel="noopener">2.500 millones de libras en diez años</a>, India aprobó una misión nacional de <a href="https://quantumcomputingreport.com/government-of-india-approves-a-national-quantum-mission-with-a-budget-of-rs-6003-65-crore-730m-usd" target="_blank" rel="noopener">unos 730 millones de dólares</a> y España lanzó en 2025 su <a href="https://www.lamoncloa.gob.es/serviciosdeprensa/notasprensa/transformacion-digital-y-funcion-publica/Paginas/2025/240425-lopez-estrategia-cuantica.aspx" target="_blank" rel="noopener">primera estrategia cuántica, con unos 800 millones de euros</a>.</p>
<h3>América Latina y Colombia</h3>
<p>En la región, la cuántica crece desde universidades y comunidades. <a href="https://quantum-latino.com/" target="_blank" rel="noopener">Quantum Latino</a> reúne cada año a investigadores, empresas y estudiantes. En Colombia:</p>
<ul>
<li>La Universidad de los Andes recibió a finales de 2024 el <a href="https://thequantuminsider.com/2024/12/04/colombias-first-quantum-computer-advancing-education-research-and-technological-innovation/" target="_blank" rel="noopener">primer computador cuántico del país</a>, un equipo educativo de resonancia magnética que funciona a temperatura ambiente, y se sumó al <a href="https://www.uniandes.edu.co/es/noticias/fisica/2025-el-ano-internacional-de-la-cuantica" target="_blank" rel="noopener">Año Internacional</a>.</li>
<li>En febrero de 2026, la UCEVA de Tuluá puso en operación, con recursos del Ministerio de Educación, el que el ministerio llama <a href="https://www.mineducacion.gov.co/1780/w3-article-427345.html" target="_blank" rel="noopener">el computador cuántico más grande del país</a>.</li>
<li>La Universidad Nacional lidera <a href="https://quantumcolombia.net/" target="_blank" rel="noopener">Quantum Colombia</a> y una Cátedra Nacional en Tecnologías Cuánticas, con divulgación para niños.</li>
<li>Minciencias abrió en 2025 la convocatoria ColombIA Inteligente, con <a href="https://dplnews.com/?p=273137" target="_blank" rel="noopener">20.000 millones de pesos</a> para proyectos de inteligencia artificial y tecnologías cuánticas.</li>
</ul>
<p>Son pasos valiosos para formar talento, no para competir con Willow o Helios.</p>

<h2>Para curiosos: tu primer programa cuántico (opcional)</h2>
<p>Si nunca has programado, puedes saltarte esta parte. Si no, simula una moneda cuántica en Python con NumPy:</p>
<pre><code>import numpy as np

# el qubit empieza en 0 (moneda quieta)
cero = np.array([1, 0])
# compuerta Hadamard: pone a girar la moneda
H = np.array([[1, 1], [1, -1]]) / np.sqrt(2)

# superposición
girando = H @ cero
# probabilidad = amplitud al cuadrado
prob = np.abs(girando) ** 2
print("Probabilidades de 0 y 1:", prob.round(2))

rng = np.random.default_rng(seed=7)
# medir 1.000 veces
medidas = rng.choice([0, 1], size=1000, p=prob)
print("Veces que salió 0 y 1:", np.bincount(medidas))

# aplicar H otra vez: interferencia
dos_veces = H @ girando
print("Después de dos H:", (np.abs(dos_veces) ** 2).round(2))</code></pre>
<p>El resultado es <code>[0.5 0.5]</code>, luego unas 500 veces cada valor y, al final, <code>[1. 0.]</code>. Ese último resultado es interferencia: al aplicar H dos veces, el camino hacia el 1 se cancela y el 0 sale siempre.</p>
<p>El siguiente paso es entrelazar dos qubits con <a href="https://www.qiskit.org" target="_blank" rel="noopener">Qiskit</a>, la biblioteca gratuita de IBM (lo probé con la versión 2.5; se instala con <code>pip install qiskit</code>):</p>
<pre><code>from qiskit import QuantumCircuit
from qiskit.primitives import StatevectorSampler

# un circuito con dos qubits, ambos en 0
qc = QuantumCircuit(2)
# el qubit 0 empieza a girar (superposición)
qc.h(0)
# si el qubit 0 es 1, voltea el 1: quedan entrelazados
qc.cx(0, 1)
# medimos los dos
qc.measure_all()

resultado = StatevectorSampler().run([qc], shots=1000).result()
print(resultado[0].data.meas.get_counts())</code></pre>
<p>Verás algo como <code>{'00': 476, '11': 524}</code>: la mitad de las veces salen dos ceros y la otra mitad dos unos, pero <strong>nunca</strong> <code>01</code> ni <code>10</code>. Son los dados conectados: el <em>estado de Bell</em>, el «hola mundo» de la computación cuántica. Esto corre en un simulador; para usar un equipo real, el plan gratuito de IBM da <a href="https://quantum.cloud.ibm.com/docs/guides/plans-overview" target="_blank" rel="noopener">hasta 10 minutos cada 28 días</a>. Y si estás empezando con Python, mi artículo <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial: ejemplos prácticos con Python</a> y la descarga gratuita <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA</a> son una buena rampa de entrada.</p>

<h2>Mitos y realidades</h2>
<table>
<thead><tr><th>Mito</th><th>Realidad</th></tr></thead>
<tbody>
<tr><td>«Prueba todas las respuestas a la vez»</td><td>Al medir obtienes una sola respuesta. La ventaja viene de la interferencia, y solo en ciertos problemas.</td></tr>
<tr><td>«Reemplazará a mi computador»</td><td>No. Será un acelerador especializado, en la nube, junto a los supercomputadores.</td></tr>
<tr><td>«Ya puede romper todas las contraseñas»</td><td>Hoy no. Haría falta cerca de un millón de qubits de buena calidad, y la criptografía poscuántica ya está estandarizada.</td></tr>
<tr><td>«Más qubits siempre es mejor»</td><td>Importa más la calidad: pocos qubits con pocos errores valen más que muchos ruidosos.</td></tr>
<tr><td>«Multiplica miles de veces la capacidad de cualquier computador»</td><td>Se lee hasta en comunicados oficiales, pero la ventaja existe solo en tareas concretas; en casi todo lo demás, un portátil gana.</td></tr>
</tbody>
</table>

<h2>Glosario rápido</h2>
<ul>
<li><strong>Bit:</strong> unidad mínima de información clásica; vale 0 o 1.</li>
<li><strong>Qubit:</strong> bit cuántico; puede estar en una combinación de 0 y 1.</li>
<li><strong>Superposición:</strong> combinación de posibilidades, como la moneda que gira.</li>
<li><strong>Entrelazamiento:</strong> conexión que correlaciona los resultados de varios qubits.</li>
<li><strong>Interferencia:</strong> posibilidades que se refuerzan o se anulan, como olas.</li>
<li><strong>Decoherencia:</strong> pérdida de la información cuántica por culpa del entorno.</li>
<li><strong>Compuerta cuántica:</strong> operación sobre qubits, como H (pone a girar) o CNOT (entrelaza).</li>
<li><strong>Qubit lógico:</strong> qubit «confiable» formado por muchos qubits físicos que se corrigen entre sí.</li>
<li><strong>Ventaja cuántica:</strong> resolver una tarea mejor que los mejores métodos clásicos conocidos.</li>
<li><strong>Criptografía poscuántica:</strong> métodos de cifrado que resisten ataques de computadores cuánticos y funcionan en equipos normales.</li>
</ul>

<h2>Ideas para explorar en clase</h2>
<p>No hace falta un laboratorio. Estas actividades se adaptan desde noveno grado:</p>
<ul>
<li><strong>Moneda en el aula.</strong> Cada grupo lanza una moneda 50 veces, registra los resultados en una hoja de cálculo y los compara con la simulación en Python: probabilidad y frecuencia relativa.</li>
<li><strong>Circuitos con arrastrar y soltar.</strong> <a href="https://algassert.com/quirk" target="_blank" rel="noopener">Quirk</a> es un simulador gratuito en el navegador, sin registro: arrastran una compuerta H y una CNOT y ven aparecer el entrelazamiento. El <a href="https://quantum.cloud.ibm.com/composer" target="_blank" rel="noopener">IBM Quantum Composer</a> permite además enviar el circuito a un equipo real.</li>
<li><strong>Cursos gratuitos.</strong> <a href="https://quantum.cloud.ibm.com/learning" target="_blank" rel="noopener">IBM Quantum Learning</a> ofrece cursos abiertos; el de <a href="https://learning.quantum.ibm.com/course/basics-of-quantum-information" target="_blank" rel="noopener">fundamentos de la información cuántica</a> es ideal para docentes de matemáticas: usa vectores y matrices.</li>
<li><strong>Debate de mitos.</strong> Clasifiquen titulares reales con la tabla de mitos y realidades: pensamiento crítico y física a la vez.</li>
<li><strong>Evaluación.</strong> Con el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> creas un cuestionario sobre computación cuántica con varias versiones y solucionario; prueba la <a href="/examenes/demo/">demostración gratuita</a>.</li>
</ul>
<p>Si enseñas Tecnología e Informática o Matemáticas, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas de prompts probadas para planear una unidad sobre un tema STEM como este, evaluarla con rúbricas del Decreto 1290 y adaptarla con DUA. Y sobre lo que estas tecnologías significan para el trabajo, escribí <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">La IA no te reemplazará; quien la domine, sí</a>: con la cuántica pasará algo parecido.</p>

<p class="notice"><strong>Enseña lo que viene, con lo que ya tienes.</strong> El <strong>Kit de IA para docentes</strong> (Tecnología e Informática o Matemáticas, 60.000 pesos por materia) convierte un tema nuevo, como la computación cuántica, en una clase concreta. El <strong>Generador de exámenes con IA</strong> crea la evaluación con versiones y solucionario, y tiene simulador gratuito. La descarga gratuita <strong>Excel con IA</strong> incluye un primer script de Python. Ninguna reemplaza tu criterio: te dan tiempo para lo que importa.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Para pensar</h2>
<p>La computación cuántica es, quizá, la primera gran tecnología cuya ventaja casi nadie podrá comprobar por su cuenta: para verificar lo que dice una de estas máquinas hacen falta otra máquina igual, un supercomputador o un equipo de expertos en el que debemos confiar. Y su mayor riesgo, abrir los secretos que hoy guardamos cifrados, recaerá sobre todos, aunque solo unos pocos países y empresas la controlen. <strong>Si un puñado de laboratorios llega primero a una máquina capaz de leer los secretos del mundo, ¿debería tratarse como un descubrimiento científico que se comparte, como un arma que se regula o como un producto que se vende? ¿Y qué le debemos enseñar hoy a un estudiante colombiano de 15 años para que, en esa conversación, sea protagonista y no solo espectador?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:qubit}}' => $img('cuantica-bit-qubit', 540, 'Comparación entre un bit y un qubit. A la izquierda, una moneda quieta: el bit vale 0 o 1, como un interruptor apagado o encendido. A la derecha, una moneda girando: el qubit está en superposición, con 50 por ciento de probabilidad de 0 y 50 por ciento de 1 en este ejemplo, hasta que se mide. Abajo: con 1 qubit hay 2 posibilidades, con 2 hay 4, con 3 hay 8 y con 300 hay más que átomos en el universo observable', 'Un bit es una moneda quieta; un qubit, una moneda que gira hasta que la miramos.'),
    '{{img:ideas}}' => $img('cuantica-ideas', 600, 'Tres ideas clave de la computación cuántica con analogías: superposición, una moneda que gira; entrelazamiento, dos dados conectados que siempre coinciden aunque estén en Barranquilla y Leticia; interferencia, ondas que se refuerzan o se cancelan. Abajo, la decoherencia: el ruido, el calor y las vibraciones hacen caer la moneda antes de tiempo', 'Superposición, entrelazamiento e interferencia, las tres ideas que hacen distinto a un computador cuántico; la decoherencia es su enemigo.'),
    '{{img:puede}}' => $img('cuantica-puede-no-puede', 600, 'Tabla visual de lo que la computación cuántica puede y no puede hacer. Prometedor: simular moléculas para medicamentos y fertilizantes, diseñar materiales y baterías, romper el cifrado RSA en el futuro con máquinas mucho más grandes y generar aleatoriedad certificada. Incierto: optimización y logística, finanzas, inteligencia artificial cuántica y clima. No sirve o es mito: navegar, chatear y ofimática, predecir la bolsa, reemplazar tu computador y probar todo a la vez', 'Lo que la ciencia respalda, lo que aún está en duda y lo que es puro mito.'),
    '{{img:linea}}' => $img('cuantica-linea-tiempo', 640, 'Línea de tiempo de la computación cuántica de 2019 a 2026: 2019, Google Sycamore con 53 qubits; 2020, Jiuzhang fotónico en China; 2023, IBM utilidad cuántica con 127 qubits; agosto de 2024, NIST publica FIPS 203, 204 y 205; diciembre de 2024, Google Willow con 105 qubits bajo el umbral de corrección de errores; 2025, Año Internacional de la Ciencia y la Tecnología Cuánticas, Microsoft Majorana 1 en febrero, Zuchongzhi 3.0 en marzo, Quantum Echoes en octubre, IBM Nighthawk y Quantinuum Helios en noviembre; 2026, la UCEVA en Colombia en febrero, crítica en Nature a Majorana en junio e IBM anuncia ventaja cuántica verificada en julio', 'Siete años de avances y debates, de la «supremacía» de 2019 a la ventaja verificable de 2025 y 2026.'),
]);

return [
    'slug' => 'computacion-cuantica-para-que-sirve-como-cambiara-el-mundo',
    'title' => 'La computación cuántica: para qué sirve y cómo podría cambiar el mundo',
    'excerpt' => 'Qué es un qubit, qué son la superposición, el entrelazamiento y la interferencia, explicados con monedas, dados y laberintos; para qué sirve de verdad y qué es exageración; ventajas, desventajas, riesgos como «cosechar ahora, descifrar después», la criptografía poscuántica y el estado del arte en octubre de 2026, con código opcional en Python, glosario e ideas para clase.',
    'seo_title' => 'Computación cuántica: qué es, para qué sirve y cómo cambiará el mundo',
    'seo_description' => 'La computación cuántica explicada fácil: qubits, superposición y entrelazamiento con ejemplos, usos reales frente a mitos, riesgos, avances de 2026 y código Python.',
    'focus_keyword' => 'computación cuántica',
    'cover' => '/assets/img/articulos/computacion-cuantica/cuantica-portada',
    'cover_alt' => 'Portada: La computación cuántica, para qué sirve y cómo podría cambiar el mundo. Una moneda que gira representa un qubit en superposición junto a un circuito con compuertas H y CNOT que entrelaza dos qubits',
    'published_at' => '2026-10-08 19:00:00',
    'content_html' => $html,
];
