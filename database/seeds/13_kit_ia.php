<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Kits\KitIaDocentes;

/*
 * Kit de IA para docentes (EO-KIT-IA): se vende por materia. Textos en español e inglés, portada y estado.
 * Idempotente. El precio no se toca (se edita en el panel). Queda «activo» solo cuando los seis ZIP
 * (php bin/console kit:build) existen; mientras tanto sigue «Disponible pronto».
 */
return static function (): string {
    $id = KitIaDocentes::productId();
    if ($id === null) {
        return 'sin producto EO-KIT-IA (ejecuta antes 02_shop)';
    }
    $dir = '/assets/img/productos/kit-ia/';
    $cover = 'kit-de-ia-para-docentes';
    DB::update('products', [
        'cover_url' => $dir . $cover . '-960.webp',
        'cover_alt' => 'Kit de IA para docentes por materia: Matemáticas, Lengua Castellana, Ciencias Naturales, Ciencias Sociales, Inglés y Tecnología',
        'cover_width' => 960,
        'cover_height' => 640,
        'cover_srcset' => implode(', ', array_map(fn (int $w) => "$dir$cover-$w.webp {$w}w", [640, 960, 1440])),
        'sort' => 23,
    ], ['id' => $id]);

    $short = 'Recetas de instrucciones (prompts) probadas para planear, evaluar y adaptar tus clases con IA, alineadas con los Estándares, los DBA y las pruebas Saber. Eliges tu materia y recibes su kit completo: PDF imprimible y archivo de prompts listos para copiar.';
    $description = <<<'HTML'
<p>Pedirle a ChatGPT «hazme una clase de fracciones» da una respuesta genérica, pensada para cualquier país, que te toma más tiempo corregir que escribir. Este kit es distinto: cada instrucción ya trae el <strong>contexto colombiano</strong>, el <strong>referente curricular</strong> que corresponde, el formato que necesitas y un paso en el que la IA revisa su propio trabajo antes de entregártelo.</p>
<p>Se vende <strong>por materia</strong>. Al comprar eliges la tuya y recibes solo ese kit, escrito para lo que de verdad pasa en esa área: los errores que la IA comete en matemáticas no son los mismos que comete en inglés o en sociales.</p>
<h3>Qué trae el kit de cada materia</h3>
<ul>
<li><strong>Entre 24 y 30 recetas</strong> organizadas por tarea —planeación, evaluación, adaptación e inclusión, recursos, retroalimentación y gestión— y por grados, de transición a 11.°. Cada una con cuándo usarla, la tabla de variables para llenar, la instrucción completa, preguntas de seguimiento, un <strong>ejemplo de resultado revisado por un docente experto</strong> y la lista de lo que debes verificar.</li>
<li><strong>Referentes curriculares</strong> del área explicados en lenguaje claro: Estándares Básicos de Competencias, Derechos Básicos de Aprendizaje, competencias y componentes de las pruebas Saber, y cómo citarlos en tu planeación.</li>
<li><strong>Flujos de trabajo</strong> que encadenan recetas: de la malla a la nota de una unidad completa en una sola tarde.</li>
<li><strong>Banco de rúbricas</strong> con la escala del Decreto 1290 de 2009 (Superior, Alto, Básico y Bajo).</li>
<li><strong>Errores típicos de la IA en tu materia</strong>, cómo detectarlos y cómo corregirlos.</li>
<li><strong>Banco de contextos colombianos</strong> auténticos para problemas, lecturas y proyectos.</li>
<li>Capítulos comunes: DUA y ajustes razonables del PIAR (Decreto 1421 de 2017), privacidad de los datos de tus estudiantes (Ley 1581 de 2012), un acuerdo de uso de la IA para tu aula y un glosario.</li>
</ul>
<h3>Materias disponibles</h3>
<p>Matemáticas · Lengua Castellana · Ciencias Naturales y Educación Ambiental · Ciencias Sociales · Inglés · Tecnología e Informática.</p>
<p>Las instrucciones funcionan en ChatGPT, Gemini, Claude o Copilot, en sus versiones gratuitas o de pago. La IA no reemplaza tu criterio: este kit está diseñado para que la uses como un asistente rápido y confiable, y para que siempre sepas qué revisar.</p>
HTML;
    $includes = '<ul><li>Kit de la materia que elijas en un ZIP: guía en PDF lista para imprimir (tamaño carta) y archivo <em>prompts.txt</em> con todas las instrucciones para copiar y pegar.</li><li>24 a 30 recetas con ejemplo revisado y lista de verificación, de transición a 11.°.</li><li>Flujos de trabajo, rúbricas con la escala del Decreto 1290, errores típicos de la IA en la materia y banco de contextos colombianos.</li><li>Capítulos de DUA y PIAR, privacidad (Ley 1581) y acuerdo de uso de la IA en el aula.</li><li>Actualizaciones de la edición 2026 sin costo.</li></ul>';
    $faq = [
        ['q' => '¿Qué materias hay?', 'a' => 'Matemáticas, Lengua Castellana, Ciencias Naturales y Educación Ambiental, Ciencias Sociales, Inglés y Tecnología e Informática. Cada kit cubre de transición a 11.°, con recetas marcadas por grados.'],
        ['q' => '¿Puedo comprar varias materias?', 'a' => 'Sí. Elige una materia y agrégala al carrito; luego vuelve, elige otra y agrégala también. Cada materia es una línea del pedido y recibes los enlaces de descarga de todas en el mismo correo.'],
        ['q' => '¿En qué se diferencia de pedirle directamente a ChatGPT?', 'a' => 'Un asistente de IA responde de forma genérica y comete errores previsibles: inventa numeraciones de DBA, da claves de respuesta incorrectas, usa contextos de otros países. Cada receta del kit trae el contexto colombiano, el referente curricular, el formato de salida y un paso de autoverificación ya probados, más un ejemplo revisado por un experto y la lista de errores a revisar. Te ahorras el ensayo y error.'],
        ['q' => '¿Necesito pagar una IA?', 'a' => 'No. Las instrucciones funcionan con las versiones gratuitas de ChatGPT, Gemini, Claude o Copilot. Con una versión de pago tendrás más capacidad de uso, pero no es necesaria.'],
        ['q' => '¿Cómo recibo el kit?', 'a' => 'Apenas se aprueba el pago te llega un correo con el enlace de descarga del ZIP de cada materia comprada. También lo encuentras en Mi cuenta con el mismo correo.'],
        ['q' => '¿Puedo compartirlo con mis compañeros?', 'a' => 'La licencia es de uso personal: puedes usar, imprimir y adaptar el material en tus clases, pero no redistribuirlo. Si quieres el kit para todo tu colegio, escríbeme y te propongo una licencia institucional.'],
    ];
    DB::upsert('product_translations', [
        'product_id' => $id,
        'locale' => 'es',
        'slug' => KitIaDocentes::SLUG,
        'title' => 'Kit de IA para docentes',
        'short_html' => "<p>$short</p>",
        'description_html' => $description,
        'includes_html' => $includes,
        'requirements' => "Un asistente de IA: ChatGPT, Gemini, Claude o Copilot (sirven las versiones gratuitas).\nUn lector de PDF y un editor de texto (Bloc de notas o similar).",
        'license_text' => 'Licencia de uso personal para el docente que compra: puedes usar, imprimir y adaptar el material en tus clases. No está permitido redistribuirlo, publicarlo ni revenderlo.',
        'faq_json' => json_encode($faq, JSON_UNESCAPED_UNICODE),
        'search_text' => strip_tags("Kit de IA para docentes $short prompts inteligencia artificial ChatGPT Gemini planeación evaluación rúbricas DBA estándares Saber matemáticas lenguaje ciencias naturales sociales inglés tecnología"),
        'seo_title' => 'Kit de IA para docentes por materia: prompts alineados con DBA',
        'seo_description' => mb_substr('Prompts probados para planear, evaluar y adaptar con IA, alineados con Estándares, DBA y Saber. Elige tu materia: PDF imprimible y prompts listos para copiar.', 0, 160),
        'needs_review' => 0,
    ], ['product_id', 'locale']);

    $shortEn = 'Tested prompt recipes to plan, assess and adapt your lessons with AI, aligned with the Colombian curriculum (Estándares, DBA and Saber tests). Choose your subject and get its full kit: a printable PDF plus a file of ready-to-copy prompts. Content in Spanish.';
    $descriptionEn = <<<'HTML'
<p>Asking ChatGPT to “make a fractions lesson” gives you a generic answer, written for any country, that takes longer to fix than to write yourself. This kit is different: every prompt already includes the <strong>Colombian context</strong>, the matching <strong>curriculum reference</strong>, the output format you need and a step where the AI checks its own work before handing it over.</p>
<p>It is sold <strong>per subject</strong>. At checkout you choose yours and receive only that kit, written for what really happens in that subject: the mistakes AI makes in math are not the ones it makes in English or social studies.</p>
<h3>What each subject kit includes</h3>
<ul>
<li><strong>24 to 30 recipes</strong> organized by task (planning, assessment, adaptation and inclusion, resources, feedback and admin) and by grade, from kindergarten to grade 11, each with when to use it, the variables to fill in, the full prompt, follow-up questions, an <strong>expert-reviewed sample output</strong> and a checklist.</li>
<li>The subject’s <strong>curriculum references</strong> explained in plain language (Estándares Básicos de Competencias, DBA and Saber test competencies).</li>
<li><strong>Workflows</strong> that chain recipes, a <strong>rubric bank</strong> using the national scale (Superior, Alto, Básico, Bajo), the <strong>typical AI mistakes</strong> in the subject and a bank of authentic Colombian contexts.</li>
<li>Shared chapters on UDL and reasonable accommodations (PIAR), student data privacy and a classroom AI-use agreement.</li>
</ul>
<p><strong>Subjects:</strong> Mathematics, Spanish Language Arts, Natural Sciences, Social Studies, English and Technology and Computing. The kit is written in Spanish for teachers in Colombia.</p>
HTML;
    $faqEn = [
        ['q' => 'Which subjects are available?', 'a' => 'Mathematics, Spanish Language Arts, Natural Sciences, Social Studies, English, and Technology and Computing. Each kit covers kindergarten to grade 11.'],
        ['q' => 'Can I buy more than one subject?', 'a' => 'Yes. Choose a subject and add it to the cart, then choose another one and add it too. Each subject is a separate line in your order and all download links arrive in the same email.'],
        ['q' => 'How is this different from just asking ChatGPT?', 'a' => 'A general AI assistant answers generically and makes predictable mistakes: made-up curriculum codes, wrong answer keys, contexts from other countries. Each recipe already includes the Colombian context, curriculum reference, output format and a tested self-check step, plus an expert-reviewed example and a list of what to verify.'],
        ['q' => 'Is the content in English?', 'a' => 'No. The kit is written in Spanish for teachers working with the Colombian curriculum. The English kit teaches English as a foreign language, with instructions in Spanish.'],
    ];
    DB::upsert('product_translations', [
        'product_id' => $id,
        'locale' => 'en',
        'slug' => 'ai-kit-for-teachers',
        'title' => 'AI Kit for Teachers',
        'short_html' => "<p>$shortEn</p>",
        'description_html' => $descriptionEn,
        'includes_html' => '<ul><li>The kit for the subject you choose, as a ZIP: printable PDF guide (letter size) and a prompts.txt file to copy and paste.</li><li>24 to 30 recipes with reviewed examples and checklists, kindergarten to grade 11.</li><li>Workflows, rubrics, typical AI mistakes and Colombian contexts.</li><li>Free updates to the 2026 edition.</li></ul>',
        'requirements' => "Any AI assistant: ChatGPT, Gemini, Claude or Copilot (free versions work).\nA PDF reader and a text editor.\nReading knowledge of Spanish.",
        'license_text' => 'Personal-use license for the teacher who buys it: use, print and adapt the material in your classes. Redistribution or resale is not allowed.',
        'faq_json' => json_encode($faqEn, JSON_UNESCAPED_UNICODE),
        'search_text' => strip_tags("AI kit for teachers $shortEn prompts ChatGPT lesson planning rubrics Colombia curriculum"),
        'seo_title' => 'AI Kit for Teachers by subject: curriculum-aligned prompts',
        'seo_description' => mb_substr('Tested AI prompts to plan, assess and adapt lessons, aligned with the Colombian curriculum. Choose your subject: printable PDF and ready-to-copy prompts.', 0, 160),
        'needs_review' => 1,
    ], ['product_id', 'locale']);

    return 'textos ES/EN y portada; estado: ' . KitIaDocentes::syncStatus();
};
