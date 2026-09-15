<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\App;
use App\Core\Controller;
use App\Helpers\I18n;
use App\Helpers\SEO;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $categoryModel = new Category();

        $featuredProducts = $productModel->getFeatured(8);
        $categories = $categoryModel->getAllActive();

        $jsonLd = [
            SEO::organizationSchema(),
            SEO::websiteSchema()
        ];

        $this->render('home', [
            'pageTitle' => App::NAME . ' | ' . I18n::t('hero_title'),
            'metaDescription' => I18n::t('hero_description'),
            'canonicalUrl' => App::url('/'),
            'jsonLd' => $jsonLd,
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'activeNav' => 'home'
        ]);
    }
}
