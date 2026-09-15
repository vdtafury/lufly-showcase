<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\I18n;
use App\Helpers\SEO;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index(): void
    {
        $breadcrumbs = [
            I18n::t('nav_lookbook') => '/catalog'
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('catalog', [
            'pageTitle' => I18n::t('catalog_page_title') . ' | ' . App::NAME,
            'metaDescription' => I18n::t('catalog_page_desc'),
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
                    'name_tr' => $p['name_tr'] ?? $p['name'],
                    'name_en' => $p['name_en'] ?? $p['name'],
                    'name_cs' => $p['name_cs'] ?? $p['name'],
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
