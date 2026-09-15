<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\SEO;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index(): void
    {
        $breadcrumbs = [
            'Digital Catalogs' => '/catalog'
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('catalog', [
            'pageTitle' => '2025 European Master Catalog & Technical Binders | ' . App::NAME,
            'metaDescription' => 'Download official Lufly 2025 sanitary ceramics catalogs, technical BIM/CAD specifications, and rimless flushing documentation.',
            'canonicalUrl' => App::url('/catalog'),
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'activeNav' => 'catalog'
        ]);
    }

    public function exportJson(): void
    {
        $productModel = new Product();
        $products = $productModel->getList([], 300, 0, 'sku-asc');

        $data = [
            'manufacturer' => App::FULL_LEGAL_NAME,
            'brand' => App::NAME,
            'export_date' => date('Y-m-d H:i:s'),
            'standards' => App::STANDARDS,
            'total_products' => count($products),
            'items' => array_map(function ($p) {
                return [
                    'sku' => $p['sku'],
                    'name' => $p['name'],
                    'category' => $p['category_name'],
                    'dimensions' => $p['dimensions'],
                    'mounting' => $p['mounting_type'],
                    'material' => $p['material'],
                    'warranty' => $p['warranty'],
                    'url' => App::url('/products/' . $p['slug']),
                    'image' => App::url($p['primary_image'])
                ];
            }, $products)
        ];

        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="Lufly_Master_Catalog_2025.json"');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
