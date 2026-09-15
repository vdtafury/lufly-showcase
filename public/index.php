<?php
declare(strict_types=1);

/**
 * Lufly Architectural Sanitary Ceramics - Front Controller Entrypoint
 * Modern European B2B Showcase & Digital Catalog
 */

// Error reporting for robust production logging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// PSR-4 Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Start session securely
use App\Helpers\Security;
Security::startSession();

// Router Initialization
use App\Core\Router;

$router = new Router();

// Routes Definition
$router->get('/', 'HomeController@index');
$router->get('/collections', 'CategoryController@index');
$router->get('/collections/{slug}', 'CategoryController@show');
$router->get('/products', 'ProductController@index');
$router->get('/products/{slug}', 'ProductController@show');
$router->get('/search', 'SearchController@index');
$router->get('/api/search', 'SearchController@api');
$router->get('/catalog', 'CatalogController@index');
$router->get('/catalog/export-json', 'CatalogController@exportJson');
$router->get('/contact', 'ContactController@index');
$router->post('/contact/submit', 'ContactController@submit');

// Dispatch Request
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (empty($_GET)) {
    $queryString = parse_url($uri, PHP_URL_QUERY) ?? ($_SERVER['QUERY_STRING'] ?? '');
    if ($queryString) {
        parse_str($queryString, $_GET);
    }
}

$router->dispatch($uri, $method);
