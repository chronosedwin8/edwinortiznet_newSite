<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * PIAR con IA: tres paquetes mensuales (5, 10 y 20 PIAR por 30 días) como productos de servicio
 * para docentes. Al aprobarse el pago, OrderService crea el paquete de créditos (PiarCredits).
 * Idempotente: actualiza textos e imagen; precio y estado solo se fijan al crearlos (se editan en el panel).
 * Solo en español: la herramienta no tiene versión en inglés.
 */
return static function (): string {
    $familyId = DB::value('SELECT id FROM product_families WHERE `key` = "docentes"');
    $dir = '/assets/img/productos/piar/';
    $packages = [
        // sku, PIAR, COP, USD, orden
        ['PIAR-5', 5, 30000, 7.50, 20],
        ['PIAR-10', 10, 50000, 12.50, 21],
        ['PIAR-20', 20, 80000, 20.00, 22],
    ];
    $count = 0;
    foreach ($packages as [$sku, $n, $cop, $usd, $sort]) {
        $slug = "piar-con-ia-$n-planes";
        $cover = "piar-con-ia-$n-planes";
        $each = number_format($cop / $n, 0, ',', '.');
        $data = [
            'sku' => $sku,
            'family_id' => $familyId !== null ? (int) $familyId : null,
            'audience' => 'docente',
            'type' => 'service',
            'cover_url' => $dir . $cover . '-960.webp',
            'cover_alt' => "Paquete de $n PIAR con IA: borrador del Plan Individual de Ajustes Razonables",
            'cover_width' => 960,
            'cover_height' => 640,
            'cover_srcset' => implode(', ', array_map(fn (int $w) => "$dir$cover-$w.webp {$w}w", [640, 960, 1440])),
            'sort' => $sort,
        ];
        $existing = DB::one('SELECT id FROM products WHERE sku = :s', ['s' => $sku]);
        if ($existing === null) {
            $id = DB::insert('products', $data + ['price_cop' => $cop, 'price_usd' => $usd, 'status' => 'active']);
        } else {
            $id = (int) $existing['id'];
            DB::update('products', $data, ['id' => $id]);
        }

        $title = "PIAR con IA: paquete de $n planes (30 días)";
        $short = "Crea hasta $n PIAR con inteligencia artificial durante 30 días: borrador completo del Plan Individual de Ajustes Razonables, edición, historial y PDF formal con el logo de tu institución.";
        $description = <<<HTML
<p>El <strong>PIAR con IA</strong> te ayuda a elaborar el Plan Individual de Ajustes Razonables que exige el <strong>Decreto 1421 de 2017</strong> sin empezar desde la hoja en blanco. Describes al estudiante en un formulario guiado —condiciones, nivel de apoyo, contexto, fortalezas, intereses, barreras y valoración por dimensiones— y la inteligencia artificial redacta un borrador completo, con lenguaje respetuoso y centrado en la persona.</p>
<p>Este paquete te permite crear <strong>hasta $n PIAR durante 30 días</strong> desde la aprobación del pago (unos \$$each por PIAR). Cada PIAR queda guardado en tu cuenta para siempre: puedes verlo, ajustar cualquier sección y descargarlo en un PDF formal con el nombre y el logo de tu institución, listo para revisar con el equipo docente y la familia.</p>
<h3>Qué contiene cada PIAR</h3>
<ul>
<li>Perfil del estudiante y descripción del contexto familiar, social y escolar.</li>
<li>Valoración pedagógica en las dimensiones cognitiva, comunicativa, socioafectiva, corporal y de participación.</li>
<li>Fortalezas, intereses y barreras para el aprendizaje y la participación.</li>
<li>Objetivos y metas por área, con indicadores observables.</li>
<li>Ajustes razonables curriculares, metodológicos, de evaluación, tiempos, materiales, comunicación y convivencia, con estrategias, responsables y frecuencia.</li>
<li>Recursos, proyectos para todo el grupo, compromisos de docentes, familia, directivos y estudiante, y plan de seguimiento.</li>
<li>Acta de acuerdo con espacios para las firmas.</li>
</ul>
<p>Antes de comprar puedes <a href="/herramientas/piar/">conocer la herramienta</a> y crear <strong>1 PIAR de prueba gratis</strong> en <a href="/piar/">edwinortiz.net/piar/</a>.</p>
<p><strong>Importante:</strong> al pagar usa el mismo correo de tu cuenta PIAR. El paquete se activa automáticamente en esa cuenta cuando se aprueba el pago. Si compras otro paquete mientras este sigue activo, se suma uno nuevo por 30 días.</p>
HTML;
        $includes = "<ul><li>Hasta $n PIAR generados con IA durante 30 días.</li><li>Historial guardado: tus PIAR siguen disponibles aunque el paquete venza.</li><li>Edición de cada sección del documento, con " . ($n * \App\Services\Piar\PiarAssist::PER_PIAR) . " redacciones con IA para ajustar los campos que necesites.</li><li>PDF formal con logo e institución, y acta de acuerdo con firmas.</li><li>Soporte por correo.</li></ul>";
        $faq = [
            ['q' => '¿Cuándo se activa el paquete?', 'a' => 'Automáticamente, apenas la pasarela aprueba el pago. Te llega un correo y lo ves en edwinortiz.net/piar/ al entrar con el mismo correo con el que pagaste.'],
            ['q' => '¿Qué pasa si no uso todos los PIAR en 30 días?', 'a' => 'Los PIAR que no uses vencen con el paquete. Los que ya generaste quedan guardados en tu cuenta para siempre, con edición y PDF.'],
            ['q' => '¿La IA reemplaza al equipo que elabora el PIAR?', 'a' => 'No. Entrega un borrador completo para que lo revisen, ajusten y firmen el equipo docente, la familia y el estudiante, como indica el Decreto 1421 de 2017.'],
            ['q' => '¿Qué datos del estudiante debo escribir?', 'a' => 'Solo las iniciales o un alias y la información pedagógica necesaria. Lo que escribes se procesa con la API de Google Gemini para redactar el borrador. Necesitas la autorización de la familia o el acudiente.'],
            ['q' => '¿Puedo pedir reembolso?', 'a' => 'Sí, mientras no hayas generado PIAR con el paquete. Consulta la política de reembolsos. Al reembolsar, los PIAR sin usar del paquete se anulan.'],
        ];
        DB::upsert('product_translations', [
            'product_id' => $id,
            'locale' => 'es',
            'slug' => $slug,
            'title' => $title,
            'short_html' => "<p>$short</p>",
            'description_html' => $description,
            'includes_html' => $includes,
            'requirements' => "Conexión a internet y un navegador actualizado (computador, tableta o celular).\nUna cuenta en edwinortiz.net/piar/ con el mismo correo de la compra.",
            'license_text' => 'Licencia de uso personal para el docente titular de la cuenta durante la vigencia del paquete. Los PIAR generados son tuyos y de tu institución. No está permitido revender el acceso.',
            'faq_json' => json_encode($faq, JSON_UNESCAPED_UNICODE),
            'search_text' => strip_tags("$title $short PIAR plan individual de ajustes razonables decreto 1421 inclusión discapacidad docentes inteligencia artificial"),
            'seo_title' => "PIAR con IA: $n planes de ajustes razonables por 30 días",
            'seo_description' => mb_substr("Crea hasta $n PIAR (Decreto 1421 de 2017) con inteligencia artificial en 30 días: borrador completo, edición, historial y PDF con el logo de tu institución.", 0, 160),
            'needs_review' => 0,
        ], ['product_id', 'locale']);
        $count++;
    }
    return "$count paquetes de PIAR con IA";
};
