<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Redirecciones 301 desde las URLs de WordPress que no existen como contenido.
 */
return static function (): string {
    $rules = [
        // [origen, destino, tipo, nota]
        ['^/page/([0-9]+)/?$', '/blog/pagina/$1/', 'regex', 'Paginación de WordPress'],
        ['/author/edwinortiz/', '/sobre-mi/', 'exact', 'Autor'],
        ['/archivos-gratis/', '/herramientas/', 'exact', 'Archivos gratis → herramientas'],
        ['/blog', '/blog/', 'exact', 'Página vacía de WordPress'],
        ['/category/excel/', '/excel/', 'exact', 'Categoría → hub'],
        ['/category/oficina/', '/excel/', 'exact', 'Categoría → hub'],
        ['/category/oficina-es/', '/excel/', 'exact', 'Categoría → hub'],
        ['/category/correos-masivos/', '/excel/', 'exact', 'Categoría → hub'],
        ['/category/concurso-docente/', '/concurso-docente/', 'exact', 'Categoría → hub'],
        ['^/category/(excel|oficina|oficina-es|correos-masivos)/page/[0-9]+/?$', '/excel/', 'regex', 'Paginación de categoría → hub'],
        ['/category/', '/blog/', 'prefix', 'Resto de categorías → blog'],
        ['/tag/', '/blog/', 'prefix', 'Etiquetas → blog'],
        ['/categoria-producto/plantillas-de-excel/', '/tienda/', 'exact', 'Categoría de WooCommerce'],
        ['/categoria-producto/cursos/', '/cursos/', 'exact', 'Categoría de WooCommerce'],
        ['/categoria-producto/software/', '/categoria-producto/combinador-de-documentos/', 'exact', 'Categoría de WooCommerce'],
        ['/categoria-producto/interland/', '/tienda/?perfil=docente', 'exact', 'Categoría de WooCommerce'],
        ['/categoria-producto/presentaciones/', '/tienda/?perfil=docente', 'exact', 'Categoría de WooCommerce'],
        ['/etiqueta-producto/', '/tienda/', 'prefix', 'Etiquetas de producto'],
        ['/comments/feed/', '/feed/', 'exact', 'Feed de comentarios'],
        ['/shop/', '/tienda/', 'exact', 'Tienda (inglés de WooCommerce)'],
        ['/cart/', '/carrito/', 'exact', 'Carrito (inglés de WooCommerce)'],
        ['/checkout/', '/finalizar-compra/', 'exact', 'Pago (inglés de WooCommerce)'],
        ['/my-account/', '/mi-cuenta/', 'exact', 'Cuenta (inglés de WooCommerce)'],
        ['/mi-cuenta/', '/mi-cuenta/', 'prefix', 'Subpáginas de Mi cuenta de WooCommerce'],
        ['/finalizar-compra/', '/finalizar-compra/', 'prefix', 'Subpáginas de pago de WooCommerce'],
    ];
    foreach ($rules as [$source, $target, $type, $note]) {
        DB::upsert('redirects', ['source' => $source, 'target' => $target, 'code' => 301, 'match_type' => $type, 'note' => $note], ['source', 'match_type']);
    }

    // /?add-to-cart={id} → ficha del producto con ese ID de WordPress (ocultos → tienda).
    $count = 0;
    foreach (DB::all('SELECT p.wp_id, p.status, t.slug FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = "es" WHERE p.wp_id IS NOT NULL') as $row) {
        $target = $row['status'] === 'hidden' ? '/tienda/' : '/producto/' . $row['slug'] . '/';
        DB::upsert('redirects', [
            'source' => '/?add-to-cart=' . $row['wp_id'], 'target' => $target, 'code' => 301, 'match_type' => 'exact', 'note' => 'add-to-cart de WooCommerce',
        ], ['source', 'match_type']);
        $count++;
    }
    \App\Services\Seo\Redirects::clear();
    return count($rules) . " reglas + $count add-to-cart";
};
