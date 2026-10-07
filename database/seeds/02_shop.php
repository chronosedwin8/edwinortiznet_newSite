<?php

declare(strict_types=1);

use App\Core\Config;
use App\Core\DB;

/*
 * Tienda: familias, asignación de los 15 productos visibles, precios en COP, tutoriales,
 * fichas (incluye, requisitos, licencia, FAQ), 3 packs y 10 productos "Disponible pronto".
 * [DECISIÓN DE EDWIN] La tasa USD_COP_RATE y los textos de requisitos/licencia deben revisarse.
 */
return static function (): string {
    $rate = (float) Config::get('USD_COP_RATE', 4000);
    $cop = static fn (float $usd): int => (int) (round($usd * $rate / 1000) * 1000);

    $families = [
        'combinador-de-documentos' => ['oficina', 1, 'Combinador de documentos', 'Combina una lista de Excel con un documento de Word y obtén un archivo independiente (DOCX o PDF) por cada registro.'],
        'qr-y-codigos-de-barras' => ['oficina', 2, 'QR y códigos de barras', 'Genera códigos QR y de barras en lote desde Excel, como imágenes PNG o etiquetas listas para imprimir.'],
        'correo-masivo' => ['oficina', 3, 'Correo masivo', 'Envía correos personalizados con adjuntos distintos, copia y copia oculta desde una lista de Excel y Outlook.'],
        'documentos-comerciales' => ['oficina', 4, 'Documentos comerciales', 'Facturas, cotizaciones y valores en letras con numeración automática.'],
        'docentes' => ['docente', 5, 'Docentes', 'Plantillas y cursos para la gestión del aula y la preparación del Concurso Docente.'],
        'servicios' => ['oficina', 6, 'Servicios', 'Acompañamiento personalizado para sacar el máximo provecho de las plantillas.'],
        'packs' => ['oficina', 7, 'Packs', 'Varias plantillas juntas a un precio menor que por separado.'],
    ];
    $familyIds = [];
    foreach ($families as $key => [$audience, $sort, $name, $desc]) {
        $id = DB::upsert('product_families', ['key' => $key, 'audience' => $audience, 'sort' => $sort], ['key']);
        DB::upsert('product_family_translations', [
            'family_id' => $id, 'locale' => 'es', 'slug' => $key, 'name' => $name, 'description_html' => "<p>$desc</p>",
        ], ['family_id', 'locale']);
        $familyIds[$key] = $id;
    }

    // --- 15 productos visibles (por wp_id) ---------------------------------------------
    $req = [
        'excel' => 'Microsoft Excel 2016 o superior para Windows (incluido Microsoft 365) con las macros habilitadas.',
        'outlook' => "Microsoft Excel 2016 o superior para Windows con las macros habilitadas.\nMicrosoft Outlook de escritorio configurado con la cuenta desde la que vas a enviar.",
        'word' => "Microsoft Excel y Microsoft Word 2016 o superior para Windows con las macros habilitadas.\nPara PDF: la exportación a PDF integrada de Word.",
        'app' => "Windows 10 u 11.\nMicrosoft Word y Microsoft Excel instalados (2016 o superior o Microsoft 365).",
        'service' => 'Haber comprado al menos una de las plantillas de la tienda y contar con conexión para una videollamada.',
        'course' => 'Conexión a internet para ver las clases en video.',
    ];
    $license = 'Licencia de uso para una persona u organización: puedes usar el archivo en tus propios equipos y en los de tu equipo de trabajo. No está permitido revender, redistribuir ni publicar el archivo o su código.';
    $includesDownload = "<ul><li>Archivo comprimido (.zip) con la plantilla lista para usar.</li><li>Instrucciones de uso.</li><li>Enlace de descarga por correo, válido por 30 días y hasta 5 descargas.</li><li>Soporte por correo para la instalación.</li></ul>";

    $visible = [
        380 => ['correo-masivo', 'oficina', 'enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook', 'outlook', 1],
        376 => ['combinador-de-documentos', 'oficina', 'combinar-y-guardar-en-documentos-independientes', 'word', 2],
        409 => ['qr-y-codigos-de-barras', 'oficina', 'codigos-qr-en-excel-como-crearlos', 'excel', 3],
        413 => ['qr-y-codigos-de-barras', 'oficina', 'como-crear-codigos-qr-sin-caducidad', 'excel', 4],
        358 => ['combinador-de-documentos', 'oficina', 'combinar-correspondencia-y-generar-pdf-individuales', 'word', 5],
        436 => ['documentos-comerciales', 'oficina', 'facturas-en-excel-con-numeracion-automatica-alfanumerica', 'excel', 6],
        396 => ['documentos-comerciales', 'oficina', 'convertir-numeros-a-letras-en-excel-con-macros', 'excel', 7],
        420 => ['documentos-comerciales', 'oficina', 'como-hacer-una-factura-en-excel-con-buscarv', 'outlook', 8],
        664 => ['qr-y-codigos-de-barras', 'oficina', 'generador-masivo-de-codigos-qr-desde-excel', 'excel', 9],
        713 => ['qr-y-codigos-de-barras', 'oficina', 'todo-lo-que-necesita-saber-sobre-codigos-de-barras-en-excel', 'excel', 10],
        706 => ['qr-y-codigos-de-barras', 'oficina', 'todo-lo-que-necesita-saber-sobre-codigos-de-barras-en-excel', 'excel', 11],
        816 => ['combinador-de-documentos', 'oficina', 'combinar-datos-de-excel-en-documentos-separados-docx-y-pdf', 'app', 12],
        349 => ['docentes', 'docente', null, 'excel', 13],
        373 => ['servicios', 'oficina', null, 'service', 14],
        371 => ['docentes', 'concurso', 'concurso-docente-2026-guia-definitiva-con-estrategias-normativa-y-simulacros-con-ia', 'course', 15],
    ];
    $postId = static fn (?string $slug): ?int => $slug ? (($v = DB::value('SELECT id FROM posts WHERE locale = "es" AND slug = :s', ['s' => $slug])) !== null ? (int) $v : null) : null;

    $faqDownload = [
        ['q' => '¿Cómo recibo la plantilla?', 'a' => 'Al aprobarse el pago recibes un correo con el enlace de descarga. También la encuentras en la página del pedido y en Mi cuenta.'],
        ['q' => '¿Qué pasa si no me funciona?', 'a' => 'Escríbeme con una captura del error y te ayudo a configurarla. Si no logramos que funcione en tu equipo, aplica la política de reembolso.'],
        ['q' => '¿Puedo modificar la plantilla?', 'a' => 'Sí, puedes adaptarla a tu trabajo. Lo que no está permitido es revenderla o distribuirla.'],
    ];
    foreach ($visible as $wpId => [$family, $audience, $tutorial, $reqKey, $sort]) {
        $product = DB::one('SELECT id, price_usd, price_cop, type FROM products WHERE wp_id = :w', ['w' => $wpId]);
        if ($product === null) {
            continue;
        }
        $data = [
            'family_id' => $familyIds[$family],
            'audience' => $audience,
            'tutorial_post_id' => $postId($tutorial),
            'sort' => $sort,
            'status' => 'active',
        ];
        if ((int) $product['price_cop'] === 0) {
            $data['price_cop'] = $cop((float) $product['price_usd']);
        }
        DB::update('products', $data, ['id' => (int) $product['id']]);
        $isDownload = $product['type'] === 'download';
        DB::update('product_translations', [
            'requirements' => $req[$reqKey],
            'license_text' => $license,
            'includes_html' => $isDownload ? $includesDownload : ($product['type'] === 'service'
                ? '<ul><li>Sesión de acompañamiento por videollamada para configurar y usar tus plantillas.</li><li>Resolución de dudas por correo durante 30 días.</li></ul>'
                : '<ul><li>Acceso a las clases del curso.</li><li>Material de práctica.</li></ul>'),
            'faq_json' => json_encode($isDownload ? $faqDownload : [
                ['q' => '¿Cómo se coordina?', 'a' => 'Después del pago te escribo al correo que registraste para acordar el horario o enviarte el acceso.'],
                ['q' => '¿Puedo pedir reembolso?', 'a' => 'Sí, mientras el servicio no se haya prestado. Consulta la política de reembolso.'],
            ], JSON_UNESCAPED_UNICODE),
        ], ['product_id' => (int) $product['id'], 'locale' => 'es']);
        // El artículo tutorial enlaza de vuelta al producto.
        if ($data['tutorial_post_id'] !== null) {
            DB::run('UPDATE posts SET related_product_id = :p WHERE id = :id AND related_product_id IS NULL', ['p' => (int) $product['id'], 'id' => $data['tutorial_post_id']]);
        }
    }
    // Las presentaciones de Interland se conservan ocultas.
    DB::run('UPDATE products SET status = "hidden", family_id = :f, audience = "docente" WHERE wp_id IN (382,385,388,390,392,394)', ['f' => $familyIds['docentes']]);
    foreach ([382, 385, 388, 390, 392, 394] as $wp) {
        DB::run('UPDATE products SET price_cop = :c WHERE wp_id = :w AND price_cop = 0', ['c' => $cop((float) DB::value('SELECT price_usd FROM products WHERE wp_id = :w', ['w' => $wp])), 'w' => $wp]);
    }

    // --- Productos nuevos "Disponible pronto" (miden demanda con la lista de espera) ----
    $soon = [
        ['EO-CERT-QR', 'combinador-de-documentos', 'oficina', 'download', 60, 'certificados-y-diplomas-masivos-con-qr-de-verificacion',
            'Certificados y diplomas masivos con QR de verificación',
            'Genera cientos de certificados o diplomas en PDF desde una lista de Excel, cada uno con un código QR único para verificar su autenticidad.',
            "<p>Si organizas cursos, eventos o capacitaciones, sabes lo que cuesta producir los certificados uno por uno y lo fácil que es falsificarlos. Esta plantilla tomará tu lista de participantes en Excel y una plantilla de diseño en Word para producir un PDF por persona.</p><p>Cada certificado llevará un código QR único que apunta a una página de verificación, de modo que quien lo reciba pueda confirmar que es auténtico.</p><p>Está pensada para instituciones educativas, centros de formación, empresas y organizadores de eventos.</p>",
            "<ul><li>Plantilla de Excel para la lista de participantes.</li><li>Plantilla de diseño en Word editable.</li><li>Generación de un PDF por participante con su código QR.</li><li>Guía para publicar la página de verificación.</li></ul>",
            $req['word']],
        ['EO-BOLETINES', 'docentes', 'docente', 'download', 35, 'boletines-e-informes-con-observaciones',
            'Boletines e informes con observaciones',
            'Genera los boletines de tus estudiantes desde Excel con notas, promedios y observaciones automáticas por desempeño.',
            "<p>Llenar boletines y observaciones de cada estudiante consume horas al final de cada periodo. Esta plantilla calculará promedios y desempeños y redactará la observación base según los resultados, para que tú solo la ajustes.</p><p>Al final generará un informe por estudiante listo para imprimir o enviar en PDF.</p>",
            "<ul><li>Plantilla de Excel para notas por periodo.</li><li>Banco de observaciones editable por desempeño.</li><li>Generación de un boletín por estudiante.</li></ul>",
            $req['word']],
        ['EO-KIT-IA', 'docentes', 'docente', 'download', 15, 'kit-de-ia-para-docentes',
            'Kit de IA para docentes',
            'Instrucciones (prompts) probadas para planear clases, crear evaluaciones y adaptar material con inteligencia artificial, con ejemplos por área.',
            "<p>La inteligencia artificial puede ahorrarte horas de planeación si sabes qué pedirle. Este kit reunirá instrucciones probadas para planear clases, diseñar rúbricas, crear evaluaciones y adaptar textos al nivel de tus estudiantes.</p><p>Cada instrucción vendrá con un ejemplo de resultado y recomendaciones para revisarlo con criterio pedagógico.</p>",
            "<ul><li>Guía en PDF con instrucciones por tarea docente.</li><li>Ejemplos por área.</li><li>Lista de verificación para revisar lo que produce la IA.</li></ul>",
            'Acceso a un asistente de IA (gratuito o de pago) y un lector de PDF.'],
        ['EO-EXAMENES', 'docentes', 'docente', 'download', 30, 'generador-de-examenes-en-varias-versiones',
            'Generador de exámenes en varias versiones',
            'Crea varias versiones del mismo examen con preguntas y opciones en distinto orden, con su hoja de respuestas, desde un banco en Excel.',
            "<p>Con un banco de preguntas en Excel, esta plantilla armará varias versiones del mismo examen reordenando preguntas y opciones, para reducir la copia en el aula.</p><p>Cada versión tendrá su clave de respuestas para calificar rápido.</p>",
            "<ul><li>Plantilla de banco de preguntas en Excel.</li><li>Generación de versiones en Word o PDF.</li><li>Clave de respuestas por versión.</li></ul>",
            $req['word']],
        ['EO-ASIST-QR', 'docentes', 'docente', 'download', 30, 'asistencia-con-qr-desde-el-celular',
            'Asistencia con QR desde el celular',
            'Toma asistencia escaneando el código QR de cada estudiante o empleado con el celular, y consolida los registros en Excel.',
            "<p>Una evolución del listado de asistencia: cada persona tendrá su código QR y la asistencia se registrará escaneándolo con el celular. Los registros se consolidarán en Excel con reportes por persona y por mes.</p>",
            "<ul><li>Generador de carnés con QR.</li><li>Registro desde el celular.</li><li>Consolidado y reportes en Excel.</li></ul>",
            'Celular con cámara y Microsoft Excel para los reportes.'],
        ['EO-MAIL-WEB', 'correo-masivo', 'oficina', 'download', 35, 'correo-masivo-para-excel-web-y-mac',
            'Correo masivo para Excel web y Mac',
            'Envía correos personalizados con adjuntos desde una lista de Excel sin macros de Windows: compatible con Excel en la web y Mac.',
            "<p>La plantilla de correo masivo más vendida funciona con Excel y Outlook de escritorio en Windows. Esta versión está pensada para quienes trabajan con Excel en la web o en Mac, sin depender de macros VBA.</p>",
            "<ul><li>Plantilla para Excel en la web y Mac.</li><li>Guía de configuración paso a paso.</li></ul>",
            'Microsoft 365 (Excel en la web) o Excel para Mac, y una cuenta de correo compatible.'],
        ['EO-INVENTARIO', 'qr-y-codigos-de-barras', 'oficina', 'download', 60, 'inventario-de-activos-fijos-completo',
            'Inventario de activos fijos completo',
            'Controla tus activos fijos en Excel: registro, ubicación, responsables, movimientos, depreciación y etiquetas con QR.',
            "<p>Además de generar etiquetas, esta plantilla llevará el control completo de los activos: registro, ubicación, responsable, traslados, bajas y depreciación, con reportes listos para auditoría.</p>",
            "<ul><li>Plantilla de inventario en Excel.</li><li>Etiquetas con QR y código de barras.</li><li>Reportes de movimientos y depreciación.</li></ul>",
            $req['excel']],
        ['EO-COTIZA', 'documentos-comerciales', 'oficina', 'download', 20, 'cotizaciones-y-cuentas-de-cobro',
            'Cotizaciones y cuentas de cobro',
            'Plantilla en Excel para emitir cotizaciones y cuentas de cobro numeradas, con el valor en letras y exportación a PDF.',
            "<p>Para independientes y pequeñas empresas: crea cotizaciones y cuentas de cobro con numeración automática, valor en letras en pesos y exportación a PDF con un clic.</p>",
            "<ul><li>Plantilla de cotización.</li><li>Plantilla de cuenta de cobro.</li><li>Registro de documentos emitidos.</li></ul>",
            $req['excel']],
        ['EO-CURSO-IA', 'docentes', 'docente', 'course', 40, 'curso-ia-para-docentes',
            'Curso: IA para docentes',
            'Curso práctico para usar la inteligencia artificial en la planeación, la evaluación y la gestión del aula, sin perder el criterio pedagógico.',
            "<p>Un curso en video, a tu ritmo, para incorporar la inteligencia artificial al trabajo docente: planeación, evaluación, retroalimentación y tareas administrativas.</p><p>Incluirá ejercicios con tus propias clases y una reflexión sobre usos responsables con estudiantes.</p>",
            "<ul><li>Clases en video.</li><li>Material descargable.</li><li>Ejercicios prácticos.</li></ul>",
            $req['course']],
    ];
    // El kit del concurso se retiró: la preparación ahora se hace en Fundales.
    DB::run('UPDATE products SET status = "hidden" WHERE sku = "EO-KIT-CONC27"');
    $soonIds = [];
    foreach ($soon as [$sku, $family, $audience, $type, $usd, $slug, $title, $short, $desc, $includes, $requirements]) {
        // Una vez creado, el Kit de IA para docentes lo administra 13_kit_ia.php (textos, portada y estado según sus archivos).
        if ($sku === 'EO-KIT-IA' && ($kitId = DB::value('SELECT id FROM products WHERE sku = :s', ['s' => $sku])) !== null) {
            $soonIds[$sku] = (int) $kitId;
            continue;
        }
        // El generador de exámenes en Excel lo reemplazó el Generador de exámenes con IA (14_examenes.php lo oculta y redirige).
        if ($sku === 'EO-EXAMENES' && DB::value('SELECT id FROM products WHERE sku = "EXAM-20"') !== null
            && ($oldId = DB::value('SELECT id FROM products WHERE sku = :s', ['s' => $sku])) !== null) {
            $soonIds[$sku] = (int) $oldId;
            continue;
        }
        $id = DB::upsert('products', [
            'sku' => $sku, 'family_id' => $familyIds[$family], 'audience' => $audience, 'type' => $type,
            'price_usd' => $usd, 'status' => 'coming_soon', 'sort' => 50,
        ], ['sku']);
        DB::run('UPDATE products SET price_cop = :c WHERE id = :id AND price_cop = 0', ['c' => $cop($usd), 'id' => $id]);
        DB::upsert('product_translations', [
            'product_id' => $id, 'locale' => 'es', 'slug' => $slug, 'title' => $title,
            'short_html' => "<p>$short</p>", 'description_html' => $desc, 'includes_html' => $includes,
            'requirements' => $requirements, 'license_text' => $license,
            'faq_json' => json_encode([
                ['q' => '¿Cuándo estará disponible?', 'a' => 'Estoy midiendo el interés antes de terminarlo. Deja tu correo en «Avísame cuando salga» y te escribo apenas esté listo.'],
                ['q' => '¿El precio puede cambiar?', 'a' => 'El precio mostrado es una referencia. Quienes estén en la lista de espera recibirán primero el precio de lanzamiento.'],
            ], JSON_UNESCAPED_UNICODE),
            'search_text' => strip_tags("$title $short $desc"),
            'seo_title' => mb_substr($title, 0, 60),
            'seo_description' => mb_substr($short, 0, 160),
        ], ['product_id', 'locale']);
        $soonIds[$sku] = $id;
    }

    // --- Packs ----------------------------------------------------------------------------
    $idsByWp = [];
    foreach (DB::all('SELECT id, wp_id FROM products WHERE wp_id IS NOT NULL') as $row) {
        $idsByWp[(int) $row['wp_id']] = (int) $row['id'];
    }
    $activeDownloads = array_map('intval', DB::column('SELECT id FROM products WHERE status = "active" AND type = "download"'));
    $packs = [
        ['EO-PACK-OFI', 99, 'pack-oficina', 'Pack Oficina', 'oficina',
            'Las plantillas más usadas en la oficina en un solo paquete: correo masivo, combinador de documentos, QR y códigos de barras y factura con envío por correo.',
            [$idsByWp[380] ?? 0, $idsByWp[376] ?? 0, $idsByWp[664] ?? 0, $idsByWp[706] ?? 0, $idsByWp[420] ?? 0]],
        ['EO-PACK-DOC', 79, 'pack-docente', 'Pack Docente', 'docente',
            'Herramientas para el día a día del aula: asistencia, boletines, generador de exámenes y documentos individuales para estudiantes y acudientes.',
            [$idsByWp[349] ?? 0, $idsByWp[358] ?? 0, $idsByWp[409] ?? 0, $soonIds['EO-BOLETINES'], $soonIds['EO-EXAMENES'], $soonIds['EO-ASIST-QR']]],
        ['EO-PACK-ANUAL', 149, 'todo-incluido-anual', 'Todo incluido anual', 'oficina',
            'Todas las plantillas de la tienda y las que salgan durante un año, con sus actualizaciones.',
            $activeDownloads],
    ];
    foreach ($packs as [$sku, $usd, $slug, $title, $audience, $short, $items]) {
        $id = DB::upsert('products', [
            'sku' => $sku, 'family_id' => $familyIds['packs'], 'audience' => $audience, 'type' => 'pack',
            'price_usd' => $usd, 'status' => 'coming_soon', 'sort' => 40,
        ], ['sku']);
        DB::run('UPDATE products SET price_cop = :c WHERE id = :id AND price_cop = 0', ['c' => $cop($usd), 'id' => $id]);
        DB::upsert('product_translations', [
            'product_id' => $id, 'locale' => 'es', 'slug' => $slug, 'title' => $title,
            'short_html' => "<p>$short</p>",
            'description_html' => "<p>$short</p><p>El pack se publicará con un precio menor que la suma de las plantillas por separado. Deja tu correo para recibir el aviso y el precio de lanzamiento.</p>",
            'includes_html' => null, 'requirements' => 'Los requisitos de cada plantilla incluida.', 'license_text' => $license,
            'faq_json' => json_encode([['q' => '¿Cuándo estará disponible?', 'a' => 'Deja tu correo en «Avísame cuando salga» y te escribo apenas esté listo.']], JSON_UNESCAPED_UNICODE),
            'search_text' => "$title $short", 'seo_title' => $title, 'seo_description' => mb_substr($short, 0, 160),
        ], ['product_id', 'locale']);
        DB::run('DELETE FROM pack_items WHERE pack_id = :p', ['p' => $id]);
        foreach (array_unique(array_filter($items)) as $item) {
            DB::run('INSERT IGNORE INTO pack_items (pack_id, product_id) VALUES (:p, :i)', ['p' => $id, 'i' => $item]);
        }
    }

    return sprintf('%d familias, 15 visibles, %d nuevos, %d packs (tasa %s)', count($families), count($soon), count($packs), $rate);
};
