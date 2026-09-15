<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\I18n;
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
            I18n::t('nav_all_products') => '/products'
        ];

        $this->render('catalog_grid', [
            'pageTitle' => I18n::t('products_page_title', ['total' => $total]) . ' | ' . App::NAME,
            'metaDescription' => I18n::t('products_page_desc'),
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
            I18n::t('nav_collections') => '/collections',
            $product['category_name'] => '/collections/' . ($product['category_slug'] ?? 'architectural-sanitary-ceramics'),
            $product['name'] => '/products/' . $product['slug']
        ];

        $jsonLd = [
            SEO::productSchema($product),
            SEO::breadcrumbsSchema($breadcrumbs)
        ];

        $this->render('product', [
            'pageTitle' => $product['name'] . ' (SKU: ' . $product['sku'] . ') | ' . App::NAME . ' ' . I18n::t('brand_subhead'),
            'metaDescription' => $product['short_description'] ?: $product['name'] . ' - ' . App::NAME . ' ' . I18n::t('hero_description'),
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
