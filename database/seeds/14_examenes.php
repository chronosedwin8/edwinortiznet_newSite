<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Examenes\ExamCredits;
use App\Services\Seo\Redirects;

/*
 * Generador de exámenes con IA: tres planes de 30 días (acumulables) como productos de servicio para docentes.
 * Al aprobarse el pago, OrderService crea la suscripción (ExamCredits::grantForOrder) y envía «examenes-plan».
 * Idempotente: actualiza textos e imagen; precio y estado solo se fijan al crearlos (se editan en el panel).
 * Además retira el producto en Excel «Generador de exámenes en varias versiones» (EO-EXAMENES): queda oculto,
 * con otro slug, y su URL redirige (301) a la presentación de la herramienta.
 *
 * ─────────────────────────────────────────────────────────────────────────────────────────────────────────
 * ANÁLISIS DE COSTOS (7 de octubre de 2026). Código: ExamCredits::analysis(); la prueba ExamenesTest lo verifica.
 * Modelo: gemini-2.5-flash, nivel pago: 0,30 USD/M tokens de entrada y 2,50 USD/M de salida (incluye el
 * razonamiento). 1 USD = 4.000 COP → entrada 1,2 COP por mil tokens, salida 10 COP por mil tokens.
 * Pasarela, peor caso: Wompi con tarjeta 2,99 % + 600 COP, más IVA del 19 % sobre la comisión.
 * PayPal (precios en USD): 5,4 % + 0,30 USD.
 *
 * Consumo medido con llamadas reales (salida visible por pregunta × versión, sin razonamiento):
 *   Matemáticas grado 9, estilo Saber, 12 preguntas × 2 versiones: 6.195 tokens de salida + 1.743 de razonamiento
 *     (≈258 por unidad); 1.739 de entrada; 34 s.
 *   Física grado 10 (MRUA), 11 × 2: 5.958 + 1.046 de razonamiento (≈271 por unidad); 1.901 de entrada; 31 s.
 *   Química grado 10, 14 × 2: 7.659 + 896 (≈274); 2.073 de entrada; 38 s.
 *   Ciencias sociales grado 7, 11 × 2, sin razonamiento: 4.758 (≈216); 1.361 de entrada; 24 s.
 *   Lengua castellana grado 5 (fábula pegada como contexto), 14 × 2, sin razonamiento: 5.353 (≈191); 1.814; 24 s.
 *   Sin razonamiento, una pregunta de matemáticas salió sin opción correcta: por eso las materias con cálculos
 *   llevan 1.280 tokens de razonamiento por llamada (con razonamiento todas las claves fueron correctas).
 *   Prueba completa (matemáticas, 13 preguntas × 3 versiones distintas, con crucigrama y sopa): plan + 4 bloques
 *   en paralelo + 1 reintento = 10.085 de entrada y 22.114 de salida (≈233 COP), 50 s. Lengua castellana,
 *   16 preguntas barajadas en 4 versiones: 4.474 de entrada y 3.639 de salida (≈40 COP), 14 s.
 *   Un problema con 3 versiones (solución paso a paso en LaTeX) superó 620 tokens por versión: el tope de
 *   problemas y ensayos es 760.
 *
 * Topes que acotan el peor caso (ExamCatalog::TYPES y ExamCredits):
 *   - Salida por llamada = Σ tope del tipo × versiones + razonamiento + 256. Topes por pregunta y versión:
 *     única 520, múltiple 540, V/F 300, corta 320, completar 400, relacionar 520, ordenar 460, problema 760,
 *     abierta 520, larga 760, crucigrama 560, sopa 460. El peor caso usa 760 para todas las unidades.
 *   - Bloques de 12 unidades en paralelo; una tabla de especificaciones (40 tokens por pregunta) si hay varios
 *     bloques; si una respuesta llega truncada se rescatan sus preguntas completas; un solo reintento facturado
 *     por examen, de hasta 6 unidades (o una pregunta con todas sus versiones).
 *   - Entrada: tema ≤ 200 caracteres, contexto ≤ 3.000, contexto de la solicitud del editor ≤ 1.500 y 30
 *     preguntas existentes; contado a 3 caracteres por token: ≤ 3.500 por llamada de generación, ≤ 5.000 en el editor.
 *   - Preguntas únicas por examen (en «versiones distintas» cuenta cada versión) + cupo extra para preguntas
 *     adicionales o reemplazos en el editor; 5 solicitudes de IA por examen; borrar no devuelve cupo.
 *   - Si la IA falla, el examen vuelve al plan como máximo 2 veces por plan (el peor caso suma esos 2 intentos).
 *
 * Plan          Precio            Límites (exámenes · versiones · preguntas únicas · extra IA)   Comisión Wompi
 * EXAM-8        29.900 COP / 9,50 USD     8 · 4 · 24 · 6                                         1.778 COP
 * EXAM-20       74.900 COP / 21,90 USD   20 · 6 · 36 · 8                                         3.379 COP
 * EXAM-40      159.900 COP / 44,90 USD   40 · 8 · 45 · 10                                        6.403 COP
 *
 * Costo de IA por examen y por mes (normal = examen típico de 20 preguntas en 2 versiones distintas con una
 * solicitud en el editor; uso máximo = todos los límites con el consumo medido; peor caso = todas las llamadas
 * llegan a su tope, más el reintento y los 2 intentos fallidos devueltos):
 *               Normal                 Uso máximo              Peor caso                     Margen peor caso
 * EXAM-8      100 COP/examen ·   797   196 COP ·  1.567        417 COP (37.024 salida) ·  4.170   80,1 % Wompi · 80,5 % PayPal
 * EXAM-20     139 COP/examen · 2.778   261 COP ·  5.226        548 COP (49.680 salida) · 12.052   79,4 % Wompi · 79,5 % PayPal
 * EXAM-40     160 COP/examen · 6.390   317 COP · 12.664        670 COP (61.456 salida) · 28.130   78,4 % Wompi · 78,3 % PayPal
 * Margen objetivo ≈ 80 % en uso normal a intenso: en uso normal 91–92 %, en uso máximo 88–89 %. El peor caso
 * teórico (todas las llamadas al tope) queda en 78–80 %; ninguna solicitud individual puede salir cara.
 * ─────────────────────────────────────────────────────────────────────────────────────────────────────────
 */
return static function (): string {
    $familyId = DB::value('SELECT id FROM product_families WHERE `key` = "docentes"');
    $dir = '/assets/img/productos/examenes/';
    $plans = [
        // sku, slug/portada, nombre, orden
        ['EXAM-8', 'generador-de-examenes-ia-esencial', 'Esencial', 23],
        ['EXAM-20', 'generador-de-examenes-ia-docente', 'Docente', 24],
        ['EXAM-40', 'generador-de-examenes-ia-institucional', 'Institucional', 25],
    ];
    $count = 0;
    foreach ($plans as [$sku, $slug, $name, $sort]) {
        $p = ExamCredits::PLANS[$sku];
        $n = $p['exams'];
        $data = [
            'sku' => $sku,
            'family_id' => $familyId !== null ? (int) $familyId : null,
            'audience' => 'docente',
            'type' => 'service',
            'cover_url' => $dir . $slug . '-960.webp',
            'cover_alt' => "Plan $name del Generador de exámenes con IA: $n exámenes en versiones A, B y C por 30 días",
            'cover_width' => 960,
            'cover_height' => 640,
            'cover_srcset' => implode(', ', array_map(fn (int $w) => "$dir$slug-$w.webp {$w}w", [640, 960, 1440])),
            'sort' => $sort,
        ];
        $existing = DB::one('SELECT id FROM products WHERE sku = :s', ['s' => $sku]);
        if ($existing === null) {
            $id = DB::insert('products', $data + ['price_cop' => $p['cop'], 'price_usd' => $p['usd'], 'status' => 'active']);
        } else {
            $id = (int) $existing['id'];
            DB::update('products', $data, ['id' => $id]);
        }
        $price = (int) DB::value('SELECT price_cop FROM products WHERE id = :id', ['id' => $id]);
        $each = number_format($price / $n, 0, ',', '.');
        $title = "Generador de exámenes con IA: plan $name ($n exámenes, 30 días)";
        $short = "Crea hasta $n exámenes con inteligencia artificial durante 30 días, con hasta {$p['versions']} versiones cada uno, hoja de respuestas, solucionario, crucigramas, sopas de letras y fórmulas LaTeX en un PDF listo para imprimir.";
        $description = <<<HTML
<p>El <strong>Generador de exámenes con IA</strong> escribe las preguntas de tu examen a partir de lo que tú decides: materia, grado, <strong>tema específico</strong>, el <strong>contexto de tu clase</strong> (lo que viste, el nivel del grupo o un texto que pegues para que las preguntas se basen en él), alcance, dificultad y estilo de redacción, incluido el contextualizado tipo Saber. Eliges cuántas preguntas de cada tipo quieres y cuántas versiones necesitas.</p>
<p>Este plan te permite crear <strong>hasta $n exámenes durante 30 días</strong> desde la aprobación del pago (unos \$$each por examen), con <strong>hasta {$p['versions']} versiones</strong> por examen y <strong>hasta {$p['questions']} preguntas únicas</strong> por examen. En el modo «versiones distintas» la IA escribe una pregunta diferente y equivalente para cada versión; en el modo «barajar» escribe las preguntas una vez y el sistema cambia el orden de las preguntas y de las opciones, con las claves recalculadas.</p>
<h3>12 tipos de pregunta</h3>
<ul>
<li>Selección múltiple con única respuesta y con múltiples respuestas.</li>
<li>Verdadero o falso, respuesta corta y completar espacios.</li>
<li>Relacionar columnas y jerarquización u ordenamiento.</li>
<li>Problemas de aplicación con solución paso a paso, preguntas abiertas y respuesta larga con rúbrica.</li>
<li>Crucigramas y sopas de letras: la IA propone las palabras y las pistas, y el sistema arma la rejilla y su solución.</li>
</ul>
<h3>Un solo PDF, listo para imprimir</h3>
<p>Para cada versión: el examen con el encabezado de tu institución (logo, docente, tiempo, fecha e instrucciones) y su <strong>hoja de respuestas</strong> con burbujas. Al final, el <strong>solucionario</strong>: claves de cada versión, equivalencias, tabla de especificaciones, soluciones, respuestas modelo y criterios de calificación. Cada página indica la versión y su número. Papel carta, oficio o media carta. En Matemáticas, Física y Química las fórmulas se escriben en LaTeX y se ven como en un libro.</p>
<p>Antes de imprimir puedes editar cualquier pregunta y pedir a la IA <strong>{$p['extra']} preguntas extra o reemplazos por examen</strong>, eligiendo el tipo, la dificultad, el estilo, el subtema y tus indicaciones.</p>
<p>Antes de comprar, prueba el <a href="/examenes/demo/">simulador gratis</a> o conoce la <a href="/herramientas/generador-de-examenes/">herramienta</a>.</p>
<p><strong>Importante:</strong> al pagar usa el mismo correo de tu cuenta del generador. El plan se activa automáticamente en esa cuenta cuando se aprueba el pago. Si compras otro plan mientras este sigue activo, se suma uno nuevo por 30 días.</p>
HTML;
        $includes = "<ul><li>Hasta $n exámenes con IA durante 30 días.</li><li>Hasta {$p['versions']} versiones por examen (distintas o barajadas) y hasta {$p['questions']} preguntas únicas por examen.</li><li>{$p['extra']} preguntas extra o reemplazos con IA por examen en el editor.</li><li>PDF con encabezado y logo, hoja de respuestas, solucionario y fórmulas LaTeX.</li><li>Historial: tus exámenes siguen disponibles aunque el plan venza.</li><li>Soporte por correo.</li></ul>";
        $faq = [
            ['q' => '¿Cuándo se activa el plan?', 'a' => 'Automáticamente, apenas la pasarela aprueba el pago. Te llega un correo y lo ves en edwinortiz.net/examenes/ al entrar con el mismo correo con el que pagaste.'],
            ['q' => '¿Qué son las preguntas únicas?', 'a' => 'Las que escribe la IA. En «versiones distintas» cuenta cada versión (10 preguntas en 3 versiones son 30); en «barajar», las preguntas se escriben una sola vez y las versiones no suman.'],
            ['q' => '¿Qué pasa si no uso todos los exámenes en 30 días?', 'a' => 'Los exámenes que no uses vencen con el plan. Los que ya generaste quedan en tu cuenta, con edición manual y PDF.'],
            ['q' => '¿Borrar un examen devuelve el cupo?', 'a' => 'No. El examen ya se generó. Si la IA falla al generarlo, el examen sí vuelve a tu plan.'],
            ['q' => '¿Puedo pedir reembolso?', 'a' => 'Sí, mientras no hayas generado exámenes con el plan. Consulta la política de reembolsos. Al reembolsar, los exámenes sin usar del plan se anulan.'],
        ];
        DB::upsert('product_translations', [
            'product_id' => $id,
            'locale' => 'es',
            'slug' => $slug,
            'title' => $title,
            'short_html' => "<p>$short</p>",
            'description_html' => $description,
            'includes_html' => $includes,
            'requirements' => "Conexión a internet y un navegador actualizado (computador, tableta o celular).\nUna cuenta en edwinortiz.net/examenes/ con el mismo correo de la compra.",
            'license_text' => 'Licencia de uso personal para el docente titular de la cuenta durante la vigencia del plan. Los exámenes generados son tuyos y de tu institución. No está permitido revender el acceso.',
            'faq_json' => json_encode($faq, JSON_UNESCAPED_UNICODE),
            'search_text' => strip_tags("$title $short generador de exámenes evaluación quiz prueba versiones A B C hoja de respuestas solucionario crucigrama sopa de letras LaTeX docentes inteligencia artificial"),
            'seo_title' => mb_substr("Generador de exámenes con IA: plan $name ($n exámenes)", 0, 60),
            'seo_description' => mb_substr("Crea hasta $n exámenes con IA en 30 días: versiones A, B, C, hoja de respuestas, solucionario, crucigramas y fórmulas LaTeX en PDF.", 0, 160),
            'needs_review' => 0,
        ], ['product_id', 'locale']);
        $count++;
    }

    // El generador en Excel (EO-EXAMENES, «pronto») queda reemplazado por esta herramienta.
    $old = DB::one('SELECT id FROM products WHERE sku = "EO-EXAMENES"');
    $note = '';
    if ($old !== null) {
        DB::run('UPDATE products SET status = "hidden" WHERE id = :id', ['id' => (int) $old['id']]);
        DB::run(
            'UPDATE product_translations SET slug = "generador-de-examenes-en-varias-versiones-excel" WHERE product_id = :id AND locale = "es" AND slug = "generador-de-examenes-en-varias-versiones"',
            ['id' => (int) $old['id']]
        );
        Redirects::add('/producto/generador-de-examenes-en-varias-versiones/', '/herramientas/generador-de-examenes/', 'Generador de exámenes en Excel reemplazado por el Generador de exámenes con IA');
        $note = ' (EO-EXAMENES oculto y redirigido)';
    }
    return "$count planes del Generador de exámenes con IA$note";
};
