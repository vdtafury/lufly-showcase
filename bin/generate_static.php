<?php
declare(strict_types=1);

/**
 * Lufly Architectural Ceramics - Static Generator & Edge Compiler
 * Pre-renders all 282 products, 14 categories, and core views into production-grade HTML
 * for lightning-fast Vercel edge deployment and 100/100 Core Web Vitals.
 */

// Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) require $file;
});

use App\Config\App;
use App\Config\Database;
use App\Core\Router;

$publicDir = dirname(__DIR__) . '/public';
$db = Database::getConnection();

function renderRoute(string $uri, string $outFilePath): void {
    global $publicDir;
    $target = $publicDir . '/' . ltrim($outFilePath, '/');
    $dir = dirname($target);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $_SERVER['REQUEST_URI'] = $uri;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['HTTP_HOST'] = 'lufly-showcase.vercel.app';

    ob_start();
    // Dispatch via Router directly
    $router = new Router();
    $router->get('/', 'HomeController@index');
    $router->get('/collections', 'CategoryController@index');
    $router->get('/collections/{slug}', 'CategoryController@show');
    $router->get('/products', 'ProductController@index');
    $router->get('/products/{slug}', 'ProductController@show');
    $router->get('/search', 'SearchController@index');
    $router->get('/catalog', 'CatalogController@index');
    $router->get('/contact', 'ContactController@index');

    $router->dispatch($uri, 'GET');
    $html = ob_get_clean();

    file_put_contents($target, $html);
}

echo "1. Generating core pages..." . PHP_EOL;
renderRoute('/', 'index.html');
renderRoute('/collections', 'collections/index.html');
renderRoute('/products', 'products/index.html');
renderRoute('/catalog', 'catalog/index.html');
renderRoute('/contact', 'contact/index.html');
renderRoute('/search', 'search/index.html');

echo "2. Generating category pages..." . PHP_EOL;
$cats = $db->query("SELECT slug FROM categories WHERE product_count > 0")->fetchAll();
foreach ($cats as $c) {
    renderRoute('/collections/' . $c['slug'], 'collections/' . $c['slug'] . '/index.html');
    renderRoute('/collections/' . $c['slug'], 'collections/' . $c['slug'] . '.html');
}

echo "3. Generating all 282 product pages..." . PHP_EOL;
$prods = $db->query("SELECT slug FROM products ORDER BY id ASC")->fetchAll();
$count = 0;
foreach ($prods as $p) {
    renderRoute('/products/' . $p['slug'], 'products/' . $p['slug'] . '/index.html');
    renderRoute('/products/' . $p['slug'], 'products/' . $p['slug'] . '.html');
    $count++;
    if ($count % 50 === 0) {
        echo "   Rendered {$count} / " . count($prods) . " products..." . PHP_EOL;
    }
}

// 404 page
$_SERVER['REQUEST_URI'] = '/404';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'lufly-showcase.vercel.app';
$homeCtrl = new \App\Controllers\HomeController();
ob_start();
$homeCtrl->notFound('Page not found');
$page404 = ob_get_clean();
file_put_contents($publicDir . '/404.html', $page404);

// Root files sync for Vercel
copy($publicDir . '/index.html', dirname(__DIR__) . '/index.html');
copy($publicDir . '/catalog/index.html', dirname(__DIR__) . '/catalog.html');

echo "Pre-rendering completed successfully! Total products: {$count}" . PHP_EOL;
