<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use App\Services\Importer\WxrImporter;

/*
 * Sobre mí y políticas (privacidad y tratamiento de datos según la Ley 1581 de 2012, términos, reembolsos y cookies).
 * [DECISIÓN DE EDWIN] Son borradores: deben revisarse (idealmente con asesoría legal) antes del lanzamiento.
 */
return static function (): string {
    $updated = '5 de octubre de 2026';
    $pages = [
        [
            'type' => 'page', 'slug' => 'sobre-mi', 'group' => 'page-about',
            'title' => 'Sobre mí',
            'seo_title' => 'Sobre Edwin Ortiz Herazo: docente de matemáticas y tecnología',
            'seo_description' => 'Docente de matemáticas y tecnología con más de 20 años de experiencia. Automatización, IA y tecnología para docentes y oficinas desde Barranquilla, Colombia.',
            'html' => <<<'HTML'
<p>Soy Edwin Ortiz Herazo, docente de matemáticas y tecnología en Barranquilla, Colombia. Llevo más de veinte años en el aula y en la formación de adultos, enseñando desde informática básica hasta automatización con Excel.</p>
<h2>Formación</h2>
<ul>
<li>Licenciado en Matemáticas y Física.</li>
<li>Magíster en Ingeniería de Sistemas.</li>
<li>Magíster en Educación.</li>
</ul>
<h2>Qué encontrarás aquí</h2>
<p>Este sitio nació para compartir lo que enseño en clase y lo que resuelvo en el trabajo diario: cómo automatizar tareas repetitivas de oficina con Excel y Word, cómo usar la inteligencia artificial y la tecnología en el aula sin perder el criterio pedagógico, y cómo prepararse con método para el Concurso Docente.</p>
<p>Escribo para tres tipos de lectores: personas que trabajan en oficina y quieren dejar de hacer a mano lo que Excel puede hacer solo, docentes que buscan recursos prácticos, y aspirantes al Concurso Docente en Colombia.</p>
<h2>Cómo se sostiene el sitio</h2>
<p>Los tutoriales son gratuitos. El sitio se sostiene con la venta de plantillas y herramientas que aplican lo que explico en los artículos, y con anuncios en algunos artículos. Si una plantilla te ahorra tiempo, comprarla es la mejor forma de apoyar este trabajo.</p>
<h2>Contacto</h2>
<p>Si tienes una duda sobre una plantilla, una propuesta de formación para tu institución o una idea para un nuevo tutorial, escríbeme desde la página de contacto o por WhatsApp.</p>
HTML,
        ],
        [
            'type' => 'policy', 'slug' => 'privacidad', 'group' => 'policy-privacy',
            'title' => 'Política de privacidad y tratamiento de datos personales',
            'seo_title' => 'Política de privacidad y tratamiento de datos',
            'seo_description' => 'Cómo trata Edwin Ortiz Herazo los datos personales en edwinortiz.net según la Ley 1581 de 2012: finalidades, derechos de los titulares y cómo ejercerlos.',
            'html' => <<<HTML
<p><em>Última actualización: $updated.</em></p>
<p>Esta política se adopta en cumplimiento de la Ley Estatutaria 1581 de 2012, el Decreto 1377 de 2013 (compilado en el Decreto 1074 de 2015) y demás normas colombianas sobre protección de datos personales.</p>
<h2>1. Responsable del tratamiento</h2>
<p>Edwin Ortiz Herazo, persona natural con domicilio en Barranquilla, Atlántico, Colombia, responsable del sitio web www.edwinortiz.net. Canal de atención: el formulario de la página de contacto de este sitio.</p>
<h2>2. Datos que se recogen</h2>
<ul>
<li><strong>Compras:</strong> nombre, correo electrónico, documento de identidad (opcional, para la facturación) y teléfono (opcional).</li>
<li><strong>Suscripción y lista de espera:</strong> correo electrónico, idioma y el formulario desde el que te suscribiste.</li>
<li><strong>Contacto:</strong> nombre, correo y el mensaje que envíes.</li>
<li><strong>Navegación:</strong> dirección IP y datos técnicos necesarios para la seguridad del sitio. Si aceptas las cookies analíticas, datos de uso agregados a través de Google Analytics.</li>
</ul>
<p>Los datos de pago (tarjetas, cuentas bancarias) los recogen directamente Mercado Pago, Wompi o PayPal; este sitio no los almacena.</p>
<h2>3. Finalidades</h2>
<ul>
<li>Procesar tus pedidos, entregar los archivos comprados y enviarte los correos relacionados con la compra.</li>
<li>Dar acceso a «Mi cuenta» mediante enlaces de un solo uso enviados a tu correo.</li>
<li>Enviarte, solo si te suscribiste y confirmaste, el boletín con nuevos tutoriales, herramientas y productos.</li>
<li>Avisarte cuando un producto de la lista de espera esté disponible.</li>
<li>Responder tus mensajes y solicitudes de soporte.</li>
<li>Cumplir obligaciones legales y contables, y prevenir fraudes y abusos.</li>
</ul>
<h2>4. Derechos del titular</h2>
<p>Como titular de los datos tienes derecho a: conocer, actualizar y rectificar tus datos; solicitar prueba de la autorización otorgada; ser informado sobre el uso que se les ha dado; presentar quejas ante la Superintendencia de Industria y Comercio por infracciones a la ley; revocar la autorización o solicitar la supresión de los datos cuando no exista un deber legal o contractual de conservarlos; y acceder gratuitamente a tus datos.</p>
<h2>5. Cómo ejercer tus derechos</h2>
<p>Envía tu solicitud desde la página de contacto indicando tu nombre, el correo con el que te registraste y lo que solicitas. Las consultas se atienden en un máximo de diez (10) días hábiles, prorrogables por cinco (5) días hábiles más; los reclamos, en un máximo de quince (15) días hábiles, prorrogables por ocho (8) días hábiles más, conforme a los artículos 14 y 15 de la Ley 1581 de 2012. Puedes darte de baja del boletín en cualquier momento con el enlace que aparece en cada correo.</p>
<h2>6. Encargados y transferencias</h2>
<p>Para operar el sitio se usan proveedores que pueden tratar datos por cuenta del responsable, algunos fuera de Colombia: el proveedor de alojamiento web, el servicio de envío de correo, las pasarelas de pago (Mercado Pago, Wompi y PayPal) y, si las aceptas, Google Analytics y Google AdSense. Estos proveedores cuentan con políticas de protección de datos propias.</p>
<h2>7. Datos de menores de edad</h2>
<p>El sitio no está dirigido a menores de edad. Las compras y suscripciones deben hacerlas personas mayores de edad.</p>
<h2>8. Seguridad y conservación</h2>
<p>Los datos se protegen con conexiones cifradas, acceso restringido y copias de seguridad. Se conservan mientras dure la relación y durante el tiempo que exijan las obligaciones legales y contables.</p>
<h2>9. Vigencia</h2>
<p>Esta política rige desde su publicación. Cualquier cambio sustancial se informará en esta página.</p>
HTML,
        ],
        [
            'type' => 'policy', 'slug' => 'terminos', 'group' => 'policy-terms',
            'title' => 'Términos y condiciones',
            'seo_title' => 'Términos y condiciones de compra y uso',
            'seo_description' => 'Condiciones de uso de edwinortiz.net y de compra de plantillas y productos digitales: precios, pagos, entrega por descarga, licencia de uso y responsabilidades.',
            'html' => <<<HTML
<p><em>Última actualización: $updated.</em></p>
<h2>1. Quién vende</h2>
<p>Los productos de este sitio los vende Edwin Ortiz Herazo, con domicilio en Barranquilla, Colombia.</p>
<h2>2. Productos</h2>
<p>Se venden productos digitales (plantillas de Excel y Word, aplicaciones y material de estudio), cursos y servicios de acompañamiento. Cada ficha describe qué incluye el producto, sus requisitos técnicos y su licencia. Revisa los requisitos antes de comprar.</p>
<h2>3. Precios y pagos</h2>
<p>En la versión en español los precios se muestran y se cobran en pesos colombianos (COP), con una referencia en dólares solo informativa; los pagos se procesan con Mercado Pago o Wompi. En la versión en inglés los precios se muestran y se cobran en dólares estadounidenses (USD) con PayPal. El precio que se cobra es el que aparece en el resumen del pedido al pagar.</p>
<h2>4. Entrega</h2>
<p>Cuando la pasarela confirma el pago, recibes un correo con los enlaces de descarga. Cada enlace es válido por 30 días y permite hasta 5 descargas; desde «Mi cuenta» puedes generar enlaces nuevos. Los cursos y servicios se coordinan por correo después del pago.</p>
<h2>5. Licencia de uso</h2>
<p>La compra otorga una licencia de uso no exclusiva para la persona u organización compradora. No está permitido revender, sublicenciar, redistribuir ni publicar los archivos o su código. Puedes modificar las plantillas para tu propio uso.</p>
<h2>6. Reembolsos y derecho de retracto</h2>
<p>Consulta la política de reembolsos. Nada de lo previsto en estos términos limita los derechos que te reconoce la Ley 1480 de 2011 (Estatuto del Consumidor).</p>
<h2>7. Responsabilidad</h2>
<p>Las plantillas se entregan probadas en los entornos indicados en los requisitos. Haz siempre una copia de seguridad de tus archivos antes de procesarlos. El vendedor no responde por daños derivados del uso en entornos distintos a los indicados o de un uso contrario a las instrucciones.</p>
<h2>8. Contenido del sitio</h2>
<p>Los artículos son informativos. Las fechas y requisitos de procesos oficiales, como el Concurso Docente, deben confirmarse en las fuentes oficiales.</p>
<h2>9. Ley aplicable</h2>
<p>Estos términos se rigen por las leyes de la República de Colombia.</p>
HTML,
        ],
        [
            'type' => 'policy', 'slug' => 'reembolsos', 'group' => 'policy-refunds',
            'title' => 'Política de reembolsos',
            'seo_title' => 'Política de reembolsos de productos digitales',
            'seo_description' => 'Cuándo y cómo pedir el reembolso de una plantilla o producto digital comprado en edwinortiz.net, y cómo se procesa según la pasarela de pago.',
            'html' => <<<HTML
<p><em>Última actualización: $updated.</em></p>
<p>Quiero que la plantilla te funcione. Por eso, antes de un reembolso, te ofrezco soporte para instalarla y configurarla en tu equipo.</p>
<h2>Cuándo procede</h2>
<ul>
<li>Si la plantilla no funciona en un equipo que cumple los requisitos de la ficha y no logramos resolverlo con soporte, dentro de los 7 días siguientes a la compra.</li>
<li>Si pagaste dos veces el mismo pedido.</li>
<li>Si compraste un curso o servicio y aún no se ha prestado.</li>
</ul>
<h2>Cuándo no procede</h2>
<ul>
<li>Cuando el equipo no cumple los requisitos indicados en la ficha (por ejemplo, Excel para Mac o Excel en la web en una plantilla que requiere Windows).</li>
<li>Cuando el producto ya se descargó y el motivo es un cambio de opinión.</li>
</ul>
<h2>Cómo pedirlo</h2>
<p>Escríbeme desde la página de contacto con la referencia del pedido (empieza por EO-) y una descripción del problema. Respondo en un máximo de 3 días hábiles. El reembolso se hace por la misma pasarela con la que pagaste (Mercado Pago, Wompi o PayPal) y los tiempos de acreditación dependen de ella y de tu banco. Al aprobarse el reembolso, los enlaces de descarga se desactivan.</p>
<h2>Derechos legales</h2>
<p>Esta política no limita los derechos de retracto y de reversión del pago previstos en la Ley 1480 de 2011 cuando sean aplicables.</p>
HTML,
        ],
        [
            'type' => 'policy', 'slug' => 'cookies', 'group' => 'policy-cookies',
            'title' => 'Política de cookies',
            'seo_title' => 'Política de cookies de edwinortiz.net',
            'seo_description' => 'Qué cookies y almacenamiento local usa edwinortiz.net, para qué sirven y cómo aceptar o rechazar las cookies de analítica y publicidad.',
            'html' => <<<HTML
<p><em>Última actualización: $updated.</em></p>
<p>Este sitio usa unas pocas cookies y el almacenamiento local del navegador. Las de analítica y publicidad solo se cargan si las aceptas.</p>
<h2>Necesarias</h2>
<ul>
<li><strong>eo_csrf:</strong> protege los formularios contra envíos falsificados.</li>
<li><strong>eo_sess:</strong> mantiene la sesión de «Mi cuenta» y del panel de administración.</li>
<li><strong>eo_cart:</strong> indica que tienes productos en el carrito.</li>
<li><strong>eo_rx:</strong> recuerda tu reacción en los artículos para que puedas cambiarla o quitarla. Es un identificador aleatorio que solo se crea cuando reaccionas y dura un año.</li>
</ul>
<h2>Preferencias (almacenamiento local)</h2>
<ul>
<li>Contenido del carrito, tema claro u oscuro, moneda de referencia, aviso de idioma descartado y tu elección sobre cookies.</li>
</ul>
<h2>Analítica y publicidad (solo con tu consentimiento)</h2>
<ul>
<li><strong>Google Analytics 4:</strong> estadísticas de uso agregadas.</li>
<li><strong>Google AdSense:</strong> anuncios en algunos artículos del blog. Nunca en la tienda, el pago ni las herramientas.</li>
</ul>
<h2>Cómo cambiar tu elección</h2>
<p>Usa el enlace «Preferencias de cookies» del pie de página o borra los datos del sitio desde tu navegador.</p>
HTML,
        ],
    ];

    $cleaner = new HtmlCleaner();
    foreach ($pages as $page) {
        $html = $cleaner->sanitize($page['html']);
        $text = HtmlCleaner::toText($html);
        DB::upsert('posts', [
            'type' => $page['type'],
            'locale' => 'es',
            'translation_group' => WxrImporter::uuid($page['group']),
            'slug' => $page['slug'],
            'title' => $page['title'],
            'excerpt' => excerpt_text($text, 200),
            'content_html' => $html,
            'content_text' => $text,
            'status' => 'published',
            'seo_title' => $page['seo_title'],
            'seo_description' => $page['seo_description'],
            'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'published_at' => '2026-10-05 12:00:00',
            'updated_at' => '2026-10-05 12:00:00',
        ], ['locale', 'slug']);
    }
    return count($pages) . ' páginas';
};
