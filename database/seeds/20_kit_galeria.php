<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Kits\KitIaDocentes;

/*
 * Kit de IA para docentes: galería «por dentro del kit» (páginas reales de los PDF, en
 * public/assets/img/productos/kit-ia/contenido/, generadas en 1800, 1200, 800 y 360 px) y artículo guía,
 * que la ficha enlaza en el cuadro de compra («¿Qué trae? Mira el contenido por dentro»). Idempotente:
 * reemplaza solo las imágenes de esa carpeta y conserva cualquier otra imagen del producto.
 */
return static function (): string {
    $id = KitIaDocentes::productId();
    if ($id === null) {
        return 'sin producto EO-KIT-IA (ejecuta antes 02_shop)';
    }
    $dir = '/assets/img/productos/kit-ia/contenido/';
    $slides = [
        ['01-materias', 'Portadas de los seis kits: Matemáticas, Lengua Castellana, Ciencias Naturales, Inglés, Ciencias Sociales y Tecnología e Informática',
            'Covers of the six subject kits: Math, Spanish Language, Natural Sciences, English, Social Studies and Technology'],
        ['02-indice', 'Índice del kit de Matemáticas: 15 capítulos e índice de recetas por tarea y grado',
            'Table of contents of the Math kit: 15 chapters and an index of recipes by task and grade'],
        ['03-receta', 'Receta MAT-01 por dentro: variables para llenar, instrucción lista para copiar, ejemplo de resultado revisado y lista de verificación',
            'Inside recipe MAT-01: variables to fill in, ready-to-copy prompt, reviewed sample output and checklist'],
        ['04-rubricas', 'Página del banco de rúbricas de Lengua Castellana con la escala del Decreto 1290: Superior, Alto, Básico y Bajo',
            'Rubric bank page from the Spanish Language kit with the national scale: Superior, High, Basic and Low'],
        ['05-errores', 'Capítulo de errores típicos de la IA en Ciencias Naturales: cómo detectarlos y cómo corregirlos',
            'Chapter on typical AI mistakes in Natural Sciences: how to spot and fix them'],
        ['06-flujos', 'Flujo de trabajo de Ciencias Sociales que encadena recetas para preparar una unidad completa',
            'Social Studies workflow that chains recipes to prepare a full unit'],
        ['07-prompts', 'Archivo de prompts en texto plano con todas las instrucciones del kit listas para copiar y pegar',
            'Plain-text prompts file with every prompt in the kit, ready to copy and paste'],
    ];
    $public = dirname(__DIR__, 2) . '/public';
    DB::run('DELETE FROM product_images WHERE product_id = :p AND url LIKE :u', ['p' => $id, 'u' => $dir . '%']);
    $sort = 10;
    foreach ($slides as [$name, $alt, $altEn]) {
        $url = $dir . $name . '-1200.webp';
        $size = @getimagesize($public . $url) ?: [1200, 800];
        DB::insert('product_images', [
            'product_id' => $id, 'url' => $url, 'alt' => $alt, 'alt_en' => $altEn,
            'width' => $size[0], 'height' => $size[1], 'sort' => $sort,
        ]);
        $sort += 10;
    }

    // Artículo guía (ES; la versión en inglés se toma de su traducción al mostrar la ficha).
    $guide = DB::value('SELECT id FROM posts WHERE locale = "es" AND slug = :s', ['s' => 'kit-de-ia-para-docentes-prompts-probados-curriculo-colombiano']);
    if ($guide !== null) {
        DB::update('products', ['tutorial_post_id' => (int) $guide], ['id' => $id]);
    }
    return count($slides) . ' imágenes en la galería' . ($guide !== null ? ' y artículo guía enlazado' : ' (sin artículo guía: ejecuta 15_kit_ia_articulo)');
};
