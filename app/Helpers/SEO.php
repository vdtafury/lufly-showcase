<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Config\App;

class SEO
{
    public static function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => ['Organization', 'Corporation'],
            'name' => App::NAME,
            'legalName' => App::FULL_LEGAL_NAME,
            'url' => App::url('/'),
            'logo' => App::url('/assets/images/brand/logo.png', 'tr'),
            'image' => App::url('/assets/images/brand/logo.png', 'tr'),
            'description' => I18n::t('footer_tagline'),
            'foundingDate' => (string)App::FOUNDED_YEAR,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Sanayi Mah. 60001 Nolu Cad. No: 28/A, Şehitkamil',
                'addressLocality' => 'Gaziantep',
                'postalCode' => '27110',
                'addressCountry' => 'TR',
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => App::PHONE,
                    'contactType' => 'sales',
                    'email' => App::SALES_EMAIL,
                    'areaServed' => ['European Union', 'United Kingdom', 'Middle East', 'Worldwide'],
                    'availableLanguage' => ['Turkish', 'English', 'Czech'],
                ],
                [
                    '@type' => 'ContactPoint',
                    'telephone' => App::PHONE,
                    'contactType' => 'customer service',
                    'email' => App::EMAIL,
                    'availableLanguage' => ['Turkish', 'English', 'Czech'],
                ]
            ],
            'sameAs' => [
                'https://www.instagram.com/lufly_tr/',
            ]
        ];
    }

    public static function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => App::NAME . ' Architectural Sanitary Ceramics',
            'inLanguage' => I18n::getLocale(),
            'url' => App::url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => App::url('/search?q={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            ]
        ];
    }

    public static function breadcrumbsSchema(array $items): array
    {
        $list = [];
        $position = 1;

        $list[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => I18n::t('nav_home'),
            'item' => App::url('/')
        ];

        foreach ($items as $name => $url) {
            $list[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => str_starts_with($url, 'http') ? $url : App::url($url)
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list
        ];
    }

    public static function productSchema(array $p): array
    {
        $price = (float)($p['price'] ?? 0);
        $primaryImg = str_starts_with($p['primary_image'] ?? '', 'http') ? $p['primary_image'] : App::url($p['primary_image'] ?? '/assets/images/brand/placeholder.png', 'tr');
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'inLanguage' => I18n::getLocale(),
            'name' => $p['name'],
            'image' => [$primaryImg],
            'description' => strip_tags((string)($p['description'] ?? $p['short_description'] ?? '')),
            'sku' => $p['sku'],
            'mpn' => $p['sku'],
            'brand' => [
                '@type' => 'Brand',
                'name' => App::NAME
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => App::FULL_LEGAL_NAME
            ],
            'material' => $p['material'] ?? '%100 Vitreous China',
            'offers' => [
                '@type' => 'Offer',
                'url' => App::url('/products/' . ($p['slug'] ?? '')),
                'priceCurrency' => 'EUR',
                'price' => $price > 0 ? number_format($price, 2, '.', '') : '99.00',
                'availability' => ($p['stock_status'] ?? 'instock') === 'instock' ? 'https://schema.org/InStock' : 'https://schema.org/PreOrder',
                'itemCondition' => 'https://schema.org/NewCondition',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => App::NAME
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => (string)($p['rating'] ?? 5.0),
                'reviewCount' => '12'
            ]
        ];
    }

    public static function itemListSchema(string $name, array $products): array
    {
        $elements = [];
        $pos = 1;
        foreach ($products as $p) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'url' => App::url('/products/' . $p['slug']),
                'name' => $p['name']
            ];
            if ($pos > 30) break;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => $name,
            'itemListElement' => $elements
        ];
    }
}
