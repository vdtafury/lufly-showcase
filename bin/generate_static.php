<?php
declare(strict_types=1);

/**
 * Lufly Architectural Ceramics - Static Generator & Multilingual Edge Compiler
 * Pre-renders all 282 products, 14 categories, and core views into production-grade HTML
 * across 3 locales: Turkish (default root), English (/en), and Czech (/cs)
 * for lightning-fast Vercel edge deployment and 100/100 Core Web Vitals.
 */

// Autoloader
spl_autoload_register(function (string $class) {
    $prefix = "App\\";
    $baseDir = dirname(__DIR__) . "/app/";

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace("\\", "/", $relativeClass) . ".php";

    if (file_exists($file)) require $file;
});

require_once dirname(__DIR__) . "/app/Helpers/I18n.php";

use App\Config\App;
use App\Config\Database;
use App\Core\Router;
use App\Helpers\I18n;

$publicDir = dirname(__DIR__) . "/public";
$db = Database::getConnection();

function renderRoute(string $uri, string $outFilePath): void {
    global $publicDir;
    $target = $publicDir . "/" . ltrim($outFilePath, "/");
    $dir = dirname($target);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $_SERVER["REQUEST_URI"] = $uri;
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_SERVER["HTTP_HOST"] = "lufly-showcase.vercel.app";
    $_SERVER["HTTPS"] = "on";
    $_SERVER["SERVER_PORT"] = 443;

    ob_start();
    // Dispatch via Router directly
    $router = new Router();
    $router->get("/", "HomeController@index");
    $router->get("/collections", "CategoryController@index");
    $router->get("/collections/{slug}", "CategoryController@show");
    $router->get("/products", "ProductController@index");
    $router->get("/products/{slug}", "ProductController@show");
    $router->get("/search", "SearchController@index");
    $router->get("/catalog", "CatalogController@index");
    $router->get("/contact", "ContactController@index");

    $router->dispatch($uri, "GET");
    $html = ob_get_clean();

    file_put_contents($target, $html);
}

$locales = ["tr", "en", "cs"];
$cats = $db->query("SELECT slug FROM categories WHERE product_count > 0")->fetchAll();
$prods = $db->query("SELECT slug FROM products ORDER BY id ASC")->fetchAll();

echo "Starting Multilingual Edge Static Compilation (TR [Default], EN, CS)..." . PHP_EOL;

foreach ($locales as $loc) {
    $prefix = $loc === "tr" ? "" : "/{$loc}";
    $dirPrefix = $loc === "tr" ? "" : "{$loc}/";

    echo "--> Compiling locale: " . strtoupper($loc) . " (Prefix: '{$prefix}')" . PHP_EOL;

    // 1. Core pages
    echo "    1. Generating core pages for [{$loc}]..." . PHP_EOL;
    $homeUri = $prefix === "" ? "/" : $prefix;
    renderRoute($homeUri, "{$dirPrefix}index.html");

    renderRoute("{$prefix}/collections", "{$dirPrefix}collections/index.html");
    renderRoute("{$prefix}/collections", "{$dirPrefix}collections.html");

    renderRoute("{$prefix}/products", "{$dirPrefix}products/index.html");
    renderRoute("{$prefix}/products", "{$dirPrefix}products.html");

    renderRoute("{$prefix}/catalog", "{$dirPrefix}catalog/index.html");
    renderRoute("{$prefix}/catalog", "{$dirPrefix}catalog.html");

    renderRoute("{$prefix}/contact", "{$dirPrefix}contact/index.html");
    renderRoute("{$prefix}/contact", "{$dirPrefix}contact.html");

    renderRoute("{$prefix}/search", "{$dirPrefix}search/index.html");
    renderRoute("{$prefix}/search", "{$dirPrefix}search.html");

    // 2. Category pages
    echo "    2. Generating " . count($cats) . " category pages for [{$loc}]..." . PHP_EOL;
    foreach ($cats as $c) {
        renderRoute("{$prefix}/collections/{$c["slug"]}", "{$dirPrefix}collections/{$c["slug"]}/index.html");
        renderRoute("{$prefix}/collections/{$c["slug"]}", "{$dirPrefix}collections/{$c["slug"]}.html");
    }

    // 3. Product pages
    echo "    3. Generating " . count($prods) . " product pages for [{$loc}]..." . PHP_EOL;
    $pCount = 0;
    foreach ($prods as $p) {
        renderRoute("{$prefix}/products/{$p["slug"]}", "{$dirPrefix}products/{$p["slug"]}/index.html");
        renderRoute("{$prefix}/products/{$p["slug"]}", "{$dirPrefix}products/{$p["slug"]}.html");
        $pCount++;
        if ($pCount % 100 === 0) {
            echo "       Rendered {$pCount} / " . count($prods) . " [{$loc}] products..." . PHP_EOL;
        }
    }
}

// 4. In-Memory Search Index Generation
echo "--> Generating tri-lingual search index (/data/search-index.json)..." . PHP_EOL;
$fullProds = $db->query("SELECT id, sku, name, name_tr, name_en, name_cs, slug, category_name, category_name_tr, category_name_en, category_name_cs, primary_image, is_featured, dimensions FROM products ORDER BY id ASC")->fetchAll();
$searchIndex = [];
foreach ($fullProds as $fp) {
    $searchIndex[] = [
        "id" => (int)$fp["id"],
        "sku" => $fp["sku"],
        "name_tr" => $fp["name_tr"] ?: $fp["name"],
        "name_en" => $fp["name_en"] ?: $fp["name"],
        "name_cs" => $fp["name_cs"] ?: $fp["name"],
        "category_name" => $fp["category_name"],
        "category_tr" => $fp["category_name_tr"] ?: $fp["category_name"],
        "category_en" => $fp["category_name_en"] ?: $fp["category_name"],
        "category_cs" => $fp["category_name_cs"] ?: $fp["category_name"],
        "slug" => $fp["slug"],
        "image" => $fp["primary_image"],
        "dimensions" => $fp["dimensions"] ?: "Standard Technical Dimensions",
        "is_featured" => (int)$fp["is_featured"],
    ];
}
if (!is_dir($publicDir . "/data")) mkdir($publicDir . "/data", 0777, true);
$searchIndexJson = json_encode($searchIndex, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($publicDir . "/data/search-index.json", $searchIndexJson);
if (!is_dir(dirname(__DIR__) . "/data")) mkdir(dirname(__DIR__) . "/data", 0777, true);
file_put_contents(dirname(__DIR__) . "/data/search-index.json", $searchIndexJson);

// 5. Technical JSON Export Datafeed
echo "--> Generating B2B JSON catalog export (/catalog/export-json)..." . PHP_EOL;
$exportPayload = [
    "manufacturer" => App::FULL_LEGAL_NAME,
    "brand" => App::NAME,
    "export_date" => date("Y-m-d H:i:s"),
    "standards" => App::STANDARDS,
    "total_products" => count($searchIndex),
    "items" => array_map(function ($p) {
        return [
            "sku" => $p["sku"],
            "name_tr" => $p["name_tr"],
            "name_en" => $p["name_en"],
            "name_cs" => $p["name_cs"],
            "category" => $p["category_name"],
            "dimensions" => $p["dimensions"],
            "url" => "https://lufly.tr/products/{$p["slug"]}",
            "image" => "https://lufly.tr{$p["image"]}"
        ];
    }, $searchIndex)
];
$exportJsonStr = json_encode($exportPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if (!is_dir($publicDir . "/catalog")) mkdir($publicDir . "/catalog", 0777, true);
file_put_contents($publicDir . "/catalog/export-json", $exportJsonStr);
file_put_contents($publicDir . "/catalog/export-json.html", $exportJsonStr);
file_put_contents($publicDir . "/data/catalog-export.json", $exportJsonStr);

// 6. Localized 404 pages
echo "--> Generating localized 404 pages (TR, EN, CS)..." . PHP_EOL;
$_SERVER["REQUEST_METHOD"] = "GET";
$_SERVER["HTTP_HOST"] = "lufly-showcase.vercel.app";
$_SERVER["HTTPS"] = "on";
$_SERVER["SERVER_PORT"] = 443;

// TR 404
$_SERVER["REQUEST_URI"] = "/404";
I18n::setLocale("tr");
$homeCtrl = new \App\Controllers\HomeController();
ob_start();
$homeCtrl->notFound("Sayfa bulunamadı / Page not found", false);
$page404 = ob_get_clean();
file_put_contents($publicDir . "/404.html", $page404);

// EN 404
$_SERVER["REQUEST_URI"] = "/en/404";
I18n::setLocale("en");
ob_start();
$homeCtrl->notFound("Page not found", false);
$page404En = ob_get_clean();
if (!is_dir($publicDir . "/en")) mkdir($publicDir . "/en", 0777, true);
file_put_contents($publicDir . "/en/404.html", $page404En);

// CS 404
$_SERVER["REQUEST_URI"] = "/cs/404";
I18n::setLocale("cs");
ob_start();
$homeCtrl->notFound("Stránka nenalezena", false);
$page404Cs = ob_get_clean();
if (!is_dir($publicDir . "/cs")) mkdir($publicDir . "/cs", 0777, true);
file_put_contents($publicDir . "/cs/404.html", $page404Cs);

// 7. Root files sync for Vercel and static hosting
$rootDir = dirname(__DIR__);
copy($publicDir . "/index.html", $rootDir . "/index.html");
copy($publicDir . "/catalog/index.html", $rootDir . "/catalog.html");
copy($publicDir . "/404.html", $rootDir . "/404.html");
copy($publicDir . "/collections.html", $rootDir . "/collections.html");
copy($publicDir . "/products.html", $rootDir . "/products.html");
copy($publicDir . "/contact.html", $rootDir . "/contact.html");
copy($publicDir . "/search.html", $rootDir . "/search.html");

echo "--> Generating comprehensive Multilingual Sitemap (sitemap.xml)..." . PHP_EOL;
$baseUrl = "https://lufly.tr";
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . PHP_EOL;
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml\">" . PHP_EOL;

function addSitemapUrl(string $path, string $priority = "0.8", string $freq = "weekly"): string {
    global $baseUrl;
    $clean = "/" . ltrim($path, "/");
    if ($clean === "//") $clean = "/";

    $trUrl = $clean === "/" ? $baseUrl : $baseUrl . $clean;
    $enUrl = $clean === "/" ? "{$baseUrl}/en" : "{$baseUrl}/en{$clean}";
    $csUrl = $clean === "/" ? "{$baseUrl}/cs" : "{$baseUrl}/cs{$clean}";

    $out = "  <url>\n";
    $out .= "    <loc>{$trUrl}</loc>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"tr\" href=\"{$trUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"en\" href=\"{$enUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"cs\" href=\"{$csUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$trUrl}\"/>\n";
    $out .= "    <changefreq>{$freq}</changefreq>\n";
    $out .= "    <priority>{$priority}</priority>\n";
    $out .= "  </url>\n";

    // Also add explicit URL entries for EN and CS
    $out .= "  <url>\n";
    $out .= "    <loc>{$enUrl}</loc>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"tr\" href=\"{$trUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"en\" href=\"{$enUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"cs\" href=\"{$csUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$trUrl}\"/>\n";
    $out .= "    <changefreq>{$freq}</changefreq>\n";
    $out .= "    <priority>{$priority}</priority>\n";
    $out .= "  </url>\n";

    $out .= "  <url>\n";
    $out .= "    <loc>{$csUrl}</loc>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"tr\" href=\"{$trUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"en\" href=\"{$enUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"cs\" href=\"{$csUrl}\"/>\n";
    $out .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$trUrl}\"/>\n";
    $out .= "    <changefreq>{$freq}</changefreq>\n";
    $out .= "    <priority>{$priority}</priority>\n";
    $out .= "  </url>\n";

    return $out;
}

$xml .= addSitemapUrl("/", "1.0", "daily");
$xml .= addSitemapUrl("/collections", "0.9", "daily");
$xml .= addSitemapUrl("/products", "0.9", "daily");
$xml .= addSitemapUrl("/catalog", "0.8", "monthly");
$xml .= addSitemapUrl("/contact", "0.8", "monthly");

foreach ($cats as $c) {
    $xml .= addSitemapUrl("/collections/" . $c["slug"], "0.85", "weekly");
}

foreach ($prods as $p) {
    $xml .= addSitemapUrl("/products/" . $p["slug"], "0.75", "weekly");
}

$xml .= "</urlset>" . PHP_EOL;

file_put_contents($publicDir . "/sitemap.xml", $xml);
copy($publicDir . "/sitemap.xml", dirname(__DIR__) . "/sitemap.xml");

echo "Pre-rendering completed successfully across all 3 languages!" . PHP_EOL;
echo "Total static pages generated: " . (count($locales) * (6 + count($cats) + count($prods))) . PHP_EOL;
