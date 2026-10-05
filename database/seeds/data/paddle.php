<?php

declare(strict_types=1);

// Artículo de opinión e información: experiencia con Paddle como pasarela para vender software.
return [
    'slug' => 'paddle-cuenta-cerrada-verificacion-dominio-software-ia',
    'title' => 'Paddle cerró mi cuenta: políticas ocultas, software con IA y verificación de dominios',
    'excerpt' => 'Paddle te invita a crear la cuenta en minutos, pero después llegan las restricciones: no acepta servicios, rechaza software con IA, exige validar cada dominio y, si intentas resolverlo, puede cerrarte la cuenta. Mi experiencia y lo que debes revisar antes.',
    'seo_title' => 'Paddle cerró mi cuenta: lo que no te dicen antes de vender',
    'seo_description' => 'Mi experiencia con Paddle: rechazo por software con IA, no acepta servicios, verificación de cada dominio, soporte solo en inglés y cierre de la cuenta.',
    'focus_keyword' => 'Paddle',
    'cover' => 'paddle-cuenta-cerrada',
    'cover_alt' => 'Panel de estado de cuenta con dos dominios rechazados en la verificación y la cuenta cerrada',
    'content_html' => <<<'HTML'
<p>Esta es la tercera entrega de una serie que no planeé escribir. Primero conté <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">todo lo que debes saber sobre Wompi Bancolombia</a>, con sus topes y sus días hábiles. Luego expliqué por qué <a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago rechazó mis pagos altos</a> y le mostró a mis clientes un aviso de sitio fraudulento. Hoy le toca a <strong>Paddle</strong>, la plataforma que muchos recomiendan para vender software al mundo y que, en mi caso, terminó cerrando la cuenta sin una explicación útil.</p>
<p>La idea es la misma de los artículos anteriores: que si eres desarrollador, docente que crea herramientas o pequeña empresa de software en Latinoamérica, sepas qué vas a encontrar <strong>antes</strong> de invertir semanas en una integración que quizá nunca te aprueben.</p>

<h2>Qué es Paddle y por qué atrae a quien vende software</h2>
<p>Paddle no funciona como una pasarela tradicional. Se presenta como <strong>«Merchant of Record»</strong> (comerciante registrado): técnicamente, Paddle le vende tu producto al cliente final y luego te paga a ti. Esa figura tiene ventajas reales:</p>
<ul>
<li><strong>Se encarga de los impuestos.</strong> Calcula y declara impuestos como el IVA europeo o los impuestos de venta en otros países, algo muy difícil de manejar para un vendedor pequeño.</li>
<li><strong>Cobros en muchas monedas y países</strong> con una sola integración.</li>
<li><strong>Suscripciones, licencias y facturas</strong> resueltas para productos de software.</li>
<li><strong>Abrir la cuenta es fácil.</strong> El registro te invita a empezar en minutos y la documentación para desarrolladores es buena.</li>
</ul>
<p>Para alguien que vende software desde Colombia a clientes de otros países, suena a la solución perfecta. El problema es todo lo que no aparece en la página de inicio.</p>

<h2>Lo que me pasó, paso a paso</h2>

<h3>1. La invitación: «crea tu cuenta»</h3>
<p>El registro es amable y rápido. Creas la cuenta, configuras productos y precios, y empiezas a integrar el checkout en tu sitio. Nada te advierte, en ese momento, que todavía no estás aprobado para vender ni que la aprobación depende de una revisión que puede tumbar todo el trabajo.</p>

<h3>2. Mi software tiene IA, y eso no lo permiten</h3>
<p>La primera sorpresa: el software que yo había creado incorpora <strong>inteligencia artificial</strong>, y según su respuesta, eso estaba dentro de lo que sus políticas no permiten para mi caso. Hoy, cuando casi cualquier aplicación educativa o de productividad incluye funciones de IA, encontrarse con esa restricción después de haber hecho la integración es frustrante. No es algo que se destaque cuando te invitan a crear la cuenta.</p>

<h3>3. No aceptan servicios, solo software o empresas SaaS</h3>
<p>La segunda: Paddle <strong>no recibe pagos por servicios en línea</strong>. Si además de tus licencias ofreces implementación, capacitación, consultoría o desarrollo a medida, eso queda por fuera. Su modelo está hecho para <strong>software y empresas SaaS</strong> que venden productos digitales estandarizados. Para un profesional independiente o una pequeña empresa que combina software con acompañamiento, como es muy común en educación, ese límite deja la mitad del negocio sin cómo cobrar.</p>

<h3>4. Cada dominio se valida por separado</h3>
<p>La tercera fue la más confusa: <strong>no puedes usar una misma cuenta para cobrar en cualquier sitio que tengas</strong>. Cada dominio desde el que vendes tiene que pasar su propia verificación, y si el sitio no cumple su política, ese dominio no se aprueba para la pasarela ni para la integración.</p>
<p>El proceso es poco claro: no queda explícito qué revisan exactamente, qué debe tener cada página ni cuánto tarda la respuesta. Si tienes varios productos en dominios distintos, como era mi caso, multiplicas la incertidumbre por cada uno.</p>

<h3>5. Todo en inglés y con poco soporte</h3>
<p>El panel, la documentación, los correos y el soporte están <strong>solo en inglés</strong>. Para muchos emprendedores latinoamericanos eso ya es una barrera; cuando además lo que discutes son políticas de cumplimiento y matices legales, la barrera se vuelve enorme. Y el soporte es escaso: respuestas cortas, generales y sin un interlocutor que acompañe el caso.</p>

<h3>6. Intentar arreglarlo me convirtió en «fraudulento»</h3>
<p>Aquí viene lo más grave. Hice lo que haría cualquier comerciante de buena fe: ajusté los sitios, revisé las páginas y volví a intentar la validación de los dominios para cumplir lo que pedían. La respuesta no fue una orientación ni una segunda revisión: <strong>me consideraron fraudulento y cerraron la cuenta</strong>.</p>
<p>Es una lógica difícil de aceptar. El sistema te rechaza, no te explica con precisión qué cambiar, y cuando intentas corregirlo, interpreta tus intentos como una señal de riesgo. Al final, la cuenta fue negada y quedé sin pasarela, sin explicación clara y con el tiempo de integración perdido.</p>

<h2>Por qué Paddle es tan estricto</h2>
<p>Igual que con Mercado Pago, entender la lógica ayuda a decidir mejor, aunque no justifica la forma.</p>
<ul>
<li><strong>Como comerciante registrado, el riesgo es suyo.</strong> Si Paddle vende tu producto en su nombre, responde ante clientes, bancos y autoridades fiscales por lo que vendes. Por eso filtra mucho más que una pasarela común.</li>
<li><strong>Los servicios son difíciles de verificar.</strong> Una licencia de software se entrega igual a todos; un servicio depende de una persona, de plazos y de acuerdos. Para un comerciante registrado, eso es riesgo de reclamos y contracargos.</li>
<li><strong>La IA es un terreno nuevo en regulación.</strong> Derechos de autor, contenido generado y privacidad todavía están en discusión en muchos países, y algunas plataformas prefieren excluir ciertos casos antes que evaluarlos uno por uno.</li>
<li><strong>Cada dominio es una tienda distinta para ellos.</strong> Por eso revisan cada sitio: quieren ver precios, políticas, términos y el producto que realmente se vende ahí.</li>
</ul>
<p>Todo eso es comprensible. Lo que no lo es: que estas condiciones no se presenten con claridad <strong>antes</strong> de que el vendedor invierta tiempo, y que el intento de cumplirlas termine en un cierre por sospecha de fraude.</p>

<h2>Tres pasarelas, tres problemas distintos</h2>
<p>Después de Wompi, Mercado Pago y Paddle, mi conclusión es que no existe una pasarela universal. Cada una está diseñada para un tipo de negocio, y si el tuyo no encaja, lo descubres de la peor manera.</p>
<table>
<thead><tr><th>Pasarela</th><th>Para quién funciona bien</th><th>Dónde me falló</th></tr></thead>
<tbody>
<tr><td><a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi</a></td><td>Comercios en Colombia con ventas de valor bajo o medio.</td><td>Activación lenta, topes bajos por transacción y por día, gestiones presenciales para ampliarlos.</td></tr>
<tr><td><a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago</a></td><td>Montos pequeños, varios países de Latinoamérica, muchas integraciones.</td><td>Rechazo de pagos altos, aviso de sitio fraudulento al cliente, verificación con datos de terceros.</td></tr>
<tr><td>Paddle</td><td>Empresas SaaS que venden software estandarizado a otros países.</td><td>No acepta servicios, restricción a software con IA, verificación por dominio, soporte solo en inglés y cierre de la cuenta.</td></tr>
</tbody>
</table>

<h2>Antes de abrir una cuenta en Paddle, revisa esto</h2>
<ol>
<li><strong>Lee completa su política de uso aceptable</strong> (en inglés) y busca tu tipo de producto. Si tu software usa IA, genera contenido o incluye servicios, pregunta por escrito antes de integrar.</li>
<li><strong>Separa productos de servicios.</strong> Si vendes las dos cosas, necesitarás otro medio de cobro para los servicios.</li>
<li><strong>Prepara cada dominio antes de solicitar la verificación</strong>: precios visibles, descripción clara del producto, términos y condiciones, política de reembolsos, política de privacidad y datos de contacto de la empresa. Que el sitio esté terminado, no en construcción.</li>
<li><strong>No integres todo antes de la aprobación.</strong> Haz una integración mínima de prueba y espera a que el dominio esté aprobado antes de invertir más tiempo.</li>
<li><strong>Documenta cada comunicación.</strong> Guarda los correos y anota qué cambiaste y cuándo, para poder explicarlo si te piden aclaraciones.</li>
<li><strong>Ten un plan B desde el principio.</strong> No anuncies tu lanzamiento hasta que la pasarela haya aprobado la cuenta y el dominio.</li>
</ol>

<h2>Qué alternativas tienes</h2>
<p>Si vendes software con IA o combinas software con servicios, como muchos de los que trabajamos en educación, estas son rutas razonables:</p>
<ul>
<li><strong>Pasarelas tradicionales de tu país</strong> para el mercado local, sabiendo de antemano sus topes y tiempos (revisa mi experiencia con <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi</a> y con <a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago</a>).</li>
<li><strong>PayPal u otras plataformas internacionales</strong> para clientes del exterior, comparando comisiones y condiciones para servicios.</li>
<li><strong>Transferencia bancaria con factura electrónica</strong> para contratos grandes con empresas e instituciones educativas. Es menos «automático», pero rara vez falla.</li>
<li><strong>Otros comerciantes registrados</strong> para software, verificando primero por escrito si aceptan tu tipo de producto.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Paddle acepta pagos por servicios?</h3>
<p>No. Paddle está orientado a software y empresas SaaS. Servicios como consultoría, capacitación, implementación o desarrollo a medida quedan por fuera de lo que permite cobrar.</p>
<h3>¿Paddle permite vender software con inteligencia artificial?</h3>
<p>En mi caso, la respuesta fue que su política no lo permitía. Como las políticas cambian y dependen del tipo de producto, revisa su política de uso aceptable y pregunta por escrito antes de integrar si tu software usa IA.</p>
<h3>¿Por qué Paddle pide verificar cada dominio?</h3>
<p>Porque, como comerciante registrado, vende tu producto en su nombre y revisa cada sitio donde se ofrece: el producto, los precios y las políticas. Si un dominio no cumple, no se aprueba para cobrar, aunque la cuenta exista.</p>
<h3>¿Paddle tiene soporte en español?</h3>
<p>No. La plataforma, la documentación y el soporte están en inglés, y la atención es limitada. Ten esto en cuenta si vas a discutir temas de políticas o cumplimiento.</p>
<h3>¿Qué hago si Paddle me cierra la cuenta?</h3>
<p>Pide por escrito el motivo concreto y guarda toda la comunicación. Mientras tanto, activa un medio de pago alternativo para no frenar tus ventas y retira de tu sitio cualquier botón de pago que ya no funcione.</p>

<h2>Conclusión</h2>
<p>Paddle resuelve un problema real —impuestos y cobros internacionales para software—, pero lo hace con reglas estrictas que no se presentan con claridad cuando te invita a crear la cuenta. Si tu producto usa IA, si vendes servicios o si manejas varios dominios, puedes invertir semanas en una integración y terminar con la cuenta cerrada y la etiqueta de «fraudulento» por intentar cumplir.</p>
<p>Con Wompi, Mercado Pago y Paddle aprendí lo mismo: <strong>pregunta por escrito antes de integrar, prueba con un cobro real y nunca dependas de una sola pasarela</strong>. Si te pasó algo parecido con alguna de ellas, compártelo; estas experiencias le ahorran tiempo y dinero a quien viene detrás.</p>
HTML,
];
