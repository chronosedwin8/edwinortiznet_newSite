<?php

declare(strict_types=1);

use App\Admin\AdminController;
use App\Admin\HubsController as AdminHubs;
use App\Admin\MediaController as AdminMedia;
use App\Admin\AuthController as AdminAuth;
use App\Admin\OrdersController as AdminOrders;
use App\Admin\PostsController as AdminPosts;
use App\Admin\ProductsController as AdminProducts;
use App\Admin\MiscController as AdminMisc;
use App\Admin\PiarController as AdminPiar;
use App\Controllers\AccountController;
use App\Controllers\BlogController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\ContentController;
use App\Controllers\DownloadController;
use App\Controllers\HomeController;
use App\Controllers\OrderController;
use App\Controllers\PageController;
use App\Controllers\PiarController;
use App\Controllers\ProductController;
use App\Controllers\SearchController;
use App\Controllers\SeoController;
use App\Controllers\ShopController;
use App\Controllers\SubscribeController;
use App\Controllers\ToolsController;
use App\Controllers\WebhookController;
use App\Core\Router;

/*
 * Rutas. Español en la raíz (URLs de WordPress intactas); inglés bajo /en/ con slugs traducidos.
 * El orden importa: la ruta comodín /{slug}/ va al final.
 */
return static function (Router $r): void {
    $cache = ['cache' => true];

    // --- Sin idioma -------------------------------------------------------
    $r->get('/sitemap.xml', [SeoController::class, 'sitemap'], 'sitemap');
    foreach (['sitemap_index', 'post-sitemap', 'page-sitemap', 'product-sitemap', 'product_cat-sitemap', 'category-sitemap', 'wp-sitemap'] as $legacy) {
        $r->get("/$legacy.xml", [SeoController::class, 'legacySitemap']);
    }
    $r->get('/robots.txt', [SeoController::class, 'robots'], 'robots');
    $r->get('/api/buscar', [SearchController::class, 'api'], 'api.search');
    $r->post('/api/carrito', [CartController::class, 'validate'], 'api.cart');
    $r->get('/api/reacciones/{id}', [\App\Controllers\ReactionsController::class, 'show'], 'api.reactions');
    $r->post('/api/reacciones/{id}', [\App\Controllers\ReactionsController::class, 'update']);
    $r->post('/webhooks/{gateway}', [WebhookController::class, 'handle'], 'webhook');
    $r->get('/webhooks/{gateway}', [WebhookController::class, 'ping']);
    $r->get('/descarga/{token}/', [DownloadController::class, 'download'], 'download');

    // --- Panel ------------------------------------------------------------
    $r->get('/admin/', [AdminController::class, 'dashboard'], 'admin');
    $r->get('/admin/acceso/', [AdminAuth::class, 'form'], 'admin.login');
    $r->post('/admin/acceso/', [AdminAuth::class, 'login']);
    $r->post('/admin/salir/', [AdminAuth::class, 'logout'], 'admin.logout');
    $r->get('/admin/contenido/', [AdminPosts::class, 'index'], 'admin.posts');
    $r->get('/admin/contenido/nuevo/', [AdminPosts::class, 'create'], 'admin.posts.create');
    $r->post('/admin/contenido/nuevo/', [AdminPosts::class, 'store']);
    $r->post('/admin/contenido/borrar/', [AdminPosts::class, 'destroy'], 'admin.posts.delete');
    $r->get('/admin/contenido/{id}/', [AdminPosts::class, 'edit'], 'admin.posts.edit');
    $r->post('/admin/contenido/{id}/', [AdminPosts::class, 'update']);
    $r->post('/admin/contenido/{id}/traducir/', [AdminPosts::class, 'translate'], 'admin.posts.translate');
    $r->post('/admin/vista-previa/', [AdminPosts::class, 'preview'], 'admin.preview');
    $r->get('/admin/buscar/', [AdminController::class, 'search'], 'admin.search');
    $r->get('/admin/secciones/', [AdminHubs::class, 'index'], 'admin.hubs');
    $r->get('/admin/secciones/nueva/', [AdminHubs::class, 'create'], 'admin.hubs.create');
    $r->post('/admin/secciones/nueva/', [AdminHubs::class, 'store']);
    $r->post('/admin/secciones/{id}/borrar/', [AdminHubs::class, 'destroy'], 'admin.hubs.delete');
    $r->get('/admin/secciones/{id}/', [AdminHubs::class, 'edit'], 'admin.hubs.edit');
    $r->post('/admin/secciones/{id}/', [AdminHubs::class, 'update']);
    $r->get('/admin/medios/', [AdminMedia::class, 'index'], 'admin.media');
    $r->get('/admin/medios/api/', [AdminMedia::class, 'api'], 'admin.media.api');
    $r->post('/admin/medios/subir/', [AdminMedia::class, 'upload'], 'admin.media.upload');
    $r->post('/admin/medios/{id}/', [AdminMedia::class, 'update'], 'admin.media.update');
    $r->post('/admin/medios/{id}/borrar/', [AdminMedia::class, 'delete'], 'admin.media.delete');
    $r->get('/admin/productos/', [AdminProducts::class, 'index'], 'admin.products');
    $r->get('/admin/productos/nuevo/', [AdminProducts::class, 'create'], 'admin.products.create');
    $r->post('/admin/productos/nuevo/', [AdminProducts::class, 'store']);
    $r->get('/admin/productos/{id}/', [AdminProducts::class, 'edit'], 'admin.products.edit');
    $r->post('/admin/productos/{id}/', [AdminProducts::class, 'update']);
    $r->post('/admin/productos/{id}/archivo/', [AdminProducts::class, 'upload'], 'admin.products.upload');
    $r->get('/admin/familias/', [AdminProducts::class, 'families'], 'admin.families');
    $r->post('/admin/familias/', [AdminProducts::class, 'saveFamilies']);
    $r->get('/admin/familias/nueva/', [AdminProducts::class, 'createFamily'], 'admin.families.create');
    $r->post('/admin/familias/nueva/', [AdminProducts::class, 'storeFamily']);
    $r->get('/admin/familias/{id}/', [AdminProducts::class, 'editFamily'], 'admin.families.edit');
    $r->post('/admin/familias/{id}/', [AdminProducts::class, 'updateFamily']);
    $r->post('/admin/familias/{id}/borrar/', [AdminProducts::class, 'deleteFamily'], 'admin.families.delete');
    $r->get('/admin/pedidos/', [AdminOrders::class, 'index'], 'admin.orders');
    $r->get('/admin/pedidos/{id}/', [AdminOrders::class, 'show'], 'admin.orders.show');
    $r->post('/admin/pedidos/{id}/reenviar/', [AdminOrders::class, 'resend'], 'admin.orders.resend');
    $r->post('/admin/pedidos/{id}/regenerar/', [AdminOrders::class, 'regenerate'], 'admin.orders.regenerate');
    $r->post('/admin/pedidos/{id}/consultar/', [AdminOrders::class, 'check'], 'admin.orders.check');
    $r->get('/admin/suscriptores/', [AdminMisc::class, 'subscribers'], 'admin.subscribers');
    $r->get('/admin/suscriptores/exportar/', [AdminMisc::class, 'exportSubscribers'], 'admin.subscribers.export');
    $r->get('/admin/lista-de-espera/exportar/', [AdminMisc::class, 'exportWaitlist'], 'admin.waitlist.export');
    $r->get('/admin/redirecciones/', [AdminMisc::class, 'redirects'], 'admin.redirects');
    $r->post('/admin/redirecciones/', [AdminMisc::class, 'saveRedirect']);
    $r->post('/admin/redirecciones/{id}/borrar/', [AdminMisc::class, 'deleteRedirect'], 'admin.redirects.delete');
    $r->get('/admin/ajustes/', [AdminMisc::class, 'settings'], 'admin.settings');
    $r->post('/admin/ajustes/', [AdminMisc::class, 'saveSettings']);
    $r->post('/admin/cache/', [AdminMisc::class, 'flushCache'], 'admin.cache');

    // --- PIAR con IA (solo español; la presentación está en /herramientas/piar/) ---
    $r->get('/admin/piar/', [AdminPiar::class, 'index'], 'admin.piar');
    $r->post('/admin/piar/', [AdminPiar::class, 'grant']);
    $r->get('/piar/', [PiarController::class, 'dashboard'], 'piar');
    $r->get('/piar/acceso/', [PiarController::class, 'dashboard']);
    $r->post('/piar/acceso/', [PiarController::class, 'requestLink'], 'piar.access');
    $r->post('/piar/acceso/admin/', [PiarController::class, 'adminLogin'], 'piar.access.admin');
    $r->get('/piar/acceso/{token}/', [PiarController::class, 'login'], 'piar.login');
    $r->post('/piar/salir/', [PiarController::class, 'logout'], 'piar.logout');
    $r->post('/piar/terminos/', [PiarController::class, 'acceptTerms'], 'piar.terms');
    $r->get('/piar/nuevo/', [PiarController::class, 'create'], 'piar.new');
    $r->post('/piar/nuevo/', [PiarController::class, 'store']);
    $r->get('/piar/planes/', [PiarController::class, 'plans'], 'piar.plans');
    $r->get('/piar/perfil/', [PiarController::class, 'profile'], 'piar.profile');
    $r->post('/piar/perfil/', [PiarController::class, 'saveProfile']);
    $r->get('/piar/perfil/logo/', [PiarController::class, 'logo'], 'piar.logo');
    $r->get('/piar/{uuid:token}/', [PiarController::class, 'show'], 'piar.show');
    $r->get('/piar/{uuid:token}/estado/', [PiarController::class, 'status'], 'piar.status');
    $r->get('/piar/{uuid:token}/editar/', [PiarController::class, 'edit'], 'piar.edit');
    $r->post('/piar/{uuid:token}/editar/', [PiarController::class, 'update']);
    $r->get('/piar/{uuid:token}/pdf/', [PiarController::class, 'pdf'], 'piar.pdf');
    $r->post('/piar/{uuid:token}/asistente/', [PiarController::class, 'assist'], 'piar.assist');

    // --- Generador de exámenes con IA (solo español; la presentación está en /herramientas/generador-de-examenes/) ---
    $r->get('/admin/examenes/', [\App\Admin\ExamenesController::class, 'index'], 'admin.examenes');
    $r->post('/admin/examenes/', [\App\Admin\ExamenesController::class, 'grant']);
    $r->get('/examenes/', [\App\Controllers\ExamenesController::class, 'dashboard'], 'examenes');
    $r->get('/examenes/acceso/', [\App\Controllers\ExamenesController::class, 'dashboard']);
    $r->post('/examenes/acceso/', [\App\Controllers\ExamenesController::class, 'requestLink'], 'examenes.access');
    $r->post('/examenes/acceso/admin/', [\App\Controllers\ExamenesController::class, 'adminLogin'], 'examenes.access.admin');
    $r->get('/examenes/acceso/{token}/', [\App\Controllers\ExamenesController::class, 'login'], 'examenes.login');
    $r->post('/examenes/salir/', [\App\Controllers\ExamenesController::class, 'logout'], 'examenes.logout');
    $r->post('/examenes/terminos/', [\App\Controllers\ExamenesController::class, 'acceptTerms'], 'examenes.terms');
    $r->get('/examenes/nuevo/', [\App\Controllers\ExamenesController::class, 'create'], 'examenes.new');
    $r->post('/examenes/nuevo/', [\App\Controllers\ExamenesController::class, 'store']);
    $r->get('/examenes/planes/', [\App\Controllers\ExamenesController::class, 'plans'], 'examenes.plans');
    $r->get('/examenes/demo/', [\App\Controllers\ExamenesController::class, 'demo'], 'examenes.demo');
    $r->post('/examenes/demo/', [\App\Controllers\ExamenesController::class, 'demo']);
    $r->post('/examenes/demo/pdf/', [\App\Controllers\ExamenesController::class, 'demoPdf'], 'examenes.demo.pdf');
    $r->post('/examenes/vista-previa/', [\App\Controllers\ExamenesController::class, 'render'], 'examenes.render');
    $r->get('/examenes/perfil/', [\App\Controllers\ExamenesController::class, 'profile'], 'examenes.profile');
    $r->post('/examenes/perfil/', [\App\Controllers\ExamenesController::class, 'saveProfile']);
    $r->get('/examenes/perfil/logo/', [\App\Controllers\ExamenesController::class, 'logo'], 'examenes.logo');
    $r->get('/examenes/{uuid:token}/', [\App\Controllers\ExamenesController::class, 'show'], 'examenes.show');
    $r->get('/examenes/{uuid:token}/estado/', [\App\Controllers\ExamenesController::class, 'status'], 'examenes.status');
    $r->get('/examenes/{uuid:token}/editar/', [\App\Controllers\ExamenesController::class, 'edit'], 'examenes.edit');
    $r->post('/examenes/{uuid:token}/editar/', [\App\Controllers\ExamenesController::class, 'update']);
    $r->post('/examenes/{uuid:token}/ia/', [\App\Controllers\ExamenesController::class, 'ai'], 'examenes.ai');
    $r->get('/examenes/{uuid:token}/pdf/', [\App\Controllers\ExamenesController::class, 'pdf'], 'examenes.pdf');
    $r->post('/examenes/{uuid:token}/borrar/', [\App\Controllers\ExamenesController::class, 'destroy'], 'examenes.delete');

    // --- Rutas por idioma -------------------------------------------------
    $locales = [
        'es' => [
            'home' => '/',
            'blog' => '/blog/',
            'blog.page' => '/blog/pagina/{n}/',
            'shop' => '/tienda/',
            'shop.family' => '/categoria-producto/{slug}/',
            'product' => '/producto/{slug}/',
            'waitlist' => '/lista-de-espera/',
            'courses' => '/cursos/',
            'tools' => '/herramientas/',
            'tool' => '/herramientas/{slug}/',
            'about' => '/sobre-mi/',
            'contact' => '/contacto/',
            'policy' => '/politicas/{slug}/',
            'cart' => '/carrito/',
            'checkout' => '/finalizar-compra/',
            'account' => '/mi-cuenta/',
            'account.login' => '/mi-cuenta/acceso/{token}/',
            'account.logout' => '/mi-cuenta/salir/',
            'account.regenerate' => '/mi-cuenta/regenerar/{id}/',
            'order' => '/pedido/{token}/',
            'order.status' => '/pedido/{token}/estado/',
            'order.pay' => '/pedido/{token}/pagar/',
            'search' => '/buscar/',
            'subscribe' => '/suscripcion/',
            'subscribe.confirm' => '/suscripcion/confirmar/{token}/',
            'subscribe.unsubscribe' => '/suscripcion/baja/{token}/',
            'feed' => '/feed/',
            'content' => '/{slug}/',
        ],
        'en' => [
            'home' => '/en/',
            'blog' => '/en/blog/',
            'blog.page' => '/en/blog/page/{n}/',
            'shop' => '/en/shop/',
            'shop.family' => '/en/product-category/{slug}/',
            'product' => '/en/product/{slug}/',
            'waitlist' => '/en/waitlist/',
            'tools' => '/en/tools/',
            'tool' => '/en/tools/{slug}/',
            'about' => '/en/about/',
            'contact' => '/en/contact/',
            'policy' => '/en/policies/{slug}/',
            'cart' => '/en/cart/',
            'checkout' => '/en/checkout/',
            'account' => '/en/account/',
            'account.login' => '/en/account/access/{token}/',
            'account.logout' => '/en/account/logout/',
            'account.regenerate' => '/en/account/regenerate/{id}/',
            'order' => '/en/order/{token}/',
            'order.status' => '/en/order/{token}/status/',
            'order.pay' => '/en/order/{token}/pay/',
            'search' => '/en/search/',
            'subscribe' => '/en/subscribe/',
            'subscribe.confirm' => '/en/subscribe/confirm/{token}/',
            'subscribe.unsubscribe' => '/en/subscribe/unsubscribe/{token}/',
            'feed' => '/en/feed/',
            'content' => '/en/{slug}/',
        ],
    ];

    foreach ($locales as $locale => $p) {
        $r->get($p['home'], [HomeController::class, 'index'], 'home', $locale, $cache);
        $r->get($p['blog'], [BlogController::class, 'index'], 'blog', $locale, $cache);
        $r->get($p['blog.page'], [BlogController::class, 'index'], 'blog.page', $locale, $cache);
        $r->get($p['feed'], [SeoController::class, 'feed'], 'feed', $locale);
        $r->get($p['shop'], [ShopController::class, 'index'], 'shop', $locale, $cache);
        $r->get($p['shop.family'], [ShopController::class, 'family'], 'shop.family', $locale, $cache);
        $r->get($p['product'], [ProductController::class, 'show'], 'product', $locale, $cache);
        $r->post($p['waitlist'], [ProductController::class, 'waitlist'], 'waitlist', $locale);
        if (isset($p['courses'])) {
            $r->get($p['courses'], [ShopController::class, 'courses'], 'courses', $locale, $cache);
        }
        $r->get($p['tools'], [ToolsController::class, 'index'], 'tools', $locale, $cache);
        $r->get($p['tool'], [ToolsController::class, 'show'], 'tool', $locale, $cache);
        $r->get($p['about'], [PageController::class, 'about'], 'about', $locale, $cache);
        $r->get($p['contact'], [PageController::class, 'contact'], 'contact', $locale);
        $r->post($p['contact'], [PageController::class, 'sendContact'], null, $locale);
        $r->get($p['policy'], [PageController::class, 'policy'], 'policy', $locale, $cache);
        $r->get($p['cart'], [CartController::class, 'show'], 'cart', $locale);
        $r->get($p['checkout'], [CheckoutController::class, 'show'], 'checkout', $locale);
        $r->post($p['checkout'], [CheckoutController::class, 'create'], null, $locale);
        $r->get($p['account'], [AccountController::class, 'index'], 'account', $locale);
        $r->post($p['account'], [AccountController::class, 'requestLink'], null, $locale);
        $r->get($p['account.login'], [AccountController::class, 'login'], 'account.login', $locale);
        $r->post($p['account.logout'], [AccountController::class, 'logout'], 'account.logout', $locale);
        $r->post($p['account.regenerate'], [AccountController::class, 'regenerate'], 'account.regenerate', $locale);
        $r->get($p['order.status'], [OrderController::class, 'status'], 'order.status', $locale);
        $r->post($p['order.pay'], [OrderController::class, 'pay'], 'order.pay', $locale);
        $r->get($p['order'], [OrderController::class, 'show'], 'order', $locale);
        $r->get($p['search'], [SearchController::class, 'results'], 'search', $locale);
        $r->post($p['subscribe'], [SubscribeController::class, 'store'], 'subscribe', $locale);
        $r->get($p['subscribe.confirm'], [SubscribeController::class, 'confirm'], 'subscribe.confirm', $locale);
        $r->get($p['subscribe.unsubscribe'], [SubscribeController::class, 'unsubscribe'], 'subscribe.unsubscribe', $locale);
    }

    // Comodín: entradas, páginas y hubs (va al final).
    $r->get('/en/{slug}/', [ContentController::class, 'show'], 'content', 'en', $cache);
    $r->get('/{slug}/', [ContentController::class, 'show'], 'content', 'es', $cache);
};
