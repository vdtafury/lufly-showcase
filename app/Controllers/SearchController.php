<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\I18n;
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
            I18n::t('search_page_title') => '/search'
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $pageTitle = $q !== '' 
            ? I18n::t('search_results_for') . ' "' . Security::e($q) . '" | ' . App::NAME
            : I18n::t('search_page_title') . ' | ' . App::NAME;

        $this->render('search', [
            'pageTitle' => $pageTitle,
            'metaDescription' => I18n::t('search_page_desc'),
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
