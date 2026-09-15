<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\SEO;
use App\Helpers\Security;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $q = Security::sanitizeString((string)($_GET['q'] ?? ''));

        $results = [];
        if ($q !== '') {
            $results = $productModel->search($q, 60);
        }

        $breadcrumbs = [
            'Search' => '/search'
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('search', [
            'pageTitle' => ($q !== '' ? 'Search results for "' . Security::e($q) . '"' : 'Product & SKU Search') . ' | ' . App::NAME,
            'metaDescription' => 'Search all 282 certified sanitary ceramics, rimless toilets, and washbasins by SKU or name in the Lufly catalog.',
            'canonicalUrl' => App::url('/search' . ($q !== '' ? '?q=' . urlencode($q) : '')),
            'query' => $q,
            'results' => $results,
            'total' => count($results),
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'activeNav' => 'search'
        ]);
    }

    public function api(): void
    {
        $productModel = new Product();
        $q = Security::sanitizeString((string)($_GET['q'] ?? ''));

        if ($q === '' || strlen($q) < 2) {
            $this->json([]);
            return;
        }

        $results = $productModel->search($q, 8);
        $payload = array_map(function ($p) {
            return [
                'id'            => (int)$p['id'],
                'name'          => $p['name'],
                'sku'           => $p['sku'],
                'slug'          => $p['slug'],
                'category_name' => $p['category_name'],
                'image'         => $p['primary_image'],
                'url'           => '/products/' . $p['slug']
            ];
        }, $results);

        $this->json($payload);
    }
}
