<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\SEO;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $categoryModel = new Category();

        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 24;
        $offset = ($page - 1) * $limit;
        $sort = (string)($_GET['sort'] ?? 'default');
        $catFilter = !empty($_GET['category']) ? (int)$_GET['category'] : null;

        $filters = [];
        if ($catFilter) {
            $filters['category_id'] = $catFilter;
        }

        $products = $productModel->getList($filters, $limit, $offset, $sort);
        $total = $productModel->countList($filters);
        $totalPages = (int)ceil($total / $limit);
        $categories = $categoryModel->getAllActive();

        $breadcrumbs = [
            'Products' => '/products'
        ];

        $this->render('catalog_grid', [
            'pageTitle' => 'Complete Sanitary Ceramics Catalog (' . $total . ' Items) | ' . App::NAME,
            'metaDescription' => 'Explore the complete production catalog of Lufly vitreous china sanitary ceramics, rimless toilets, and designer washbasins.',
            'canonicalUrl' => App::url('/products'),
            'products' => $products,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'currentCategory' => null,
            'categories' => $categories,
            'breadcrumbs' => $breadcrumbs,
            'activeNav' => 'products'
        ]);
    }

    public function show(string $slug): void
    {
        $productModel = new Product();
        $product = $productModel->findBySlug($slug);

        if (!$product) {
            $this->notFound("The requested product does not exist in the Lufly catalog.");
            return;
        }

        $gallery = $productModel->getGalleryImages((int)$product['id']);
        $related = $productModel->getRelated((int)$product['id'], 4);

        $breadcrumbs = [
            'Collections' => '/collections',
            $product['category_name'] => '/collections/' . ($product['category_slug'] ?? 'architectural-sanitary-ceramics'),
            $product['name'] => '/products/' . $product['slug']
        ];

        $jsonLd = [
            SEO::productSchema($product),
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('product', [
            'pageTitle' => $product['name'] . ' (SKU: ' . $product['sku'] . ') | ' . App::NAME . ' European Ceramics',
            'metaDescription' => $product['short_description'] ?: $product['name'] . ' manufactured by Lufly under European standards.',
            'canonicalUrl' => App::url('/products/' . $product['slug']),
            'product' => $product,
            'gallery' => $gallery,
            'related' => $related,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'activeNav' => 'products'
        ]);
    }
}
