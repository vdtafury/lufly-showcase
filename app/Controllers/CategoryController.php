<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\SEO;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index(): void
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllActive();

        $breadcrumbs = [
            'Collections' => '/collections'
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('categories', [
            'pageTitle' => 'Architectural Sanitary Collections & Systems | ' . App::NAME,
            'metaDescription' => 'Discover Lufly signature ceramic collections: rimless wall-hung toilets, countertop washbasins, ceramic bidets, and architectural tapware.',
            'canonicalUrl' => App::url('/collections'),
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'activeNav' => 'collections'
        ]);
    }

    public function show(string $slug): void
    {
        $categoryModel = new Category();
        $productModel = new Product();

        $category = $categoryModel->findBySlug($slug);
        if (!$category) {
            $this->notFound("The collection '{$slug}' could not be located.");
            return;
        }

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 24;
        $offset = ($page - 1) * $limit;
        $sort = (string)($_GET['sort'] ?? 'default');

        $filters = [
            'category_id' => (int)$category['id']
        ];

        $products = $productModel->getList($filters, $limit, $offset, $sort);
        $total = $productModel->countList($filters);
        $totalPages = (int)ceil($total / $limit);
        $categories = $categoryModel->getAllActive();

        $breadcrumbs = [
            'Collections' => '/collections',
            $category['name'] => '/collections/' . $category['slug']
        ];

        $jsonLd = [
            SEO::breadcrumbsSchema($breadcrumbs),
            SEO::itemListSchema($category['name'], $products)
        ];

        $this->render('category', [
            'pageTitle' => $category['name'] . ' (' . $total . ' Models) | ' . App::NAME . ' European Ceramics',
            'metaDescription' => $category['description'] ?: 'Precision engineered ' . $category['name'] . ' from Lufly factory.',
            'canonicalUrl' => App::url('/collections/' . $category['slug']),
            'category' => $category,
            'products' => $products,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'activeNav' => 'collections'
        ]);
    }
}
