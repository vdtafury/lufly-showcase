<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Helpers\I18n;

class Category extends Model
{
    public const CATEGORY_THUMBNAILS = [
        'rimless-wall-hung-toilets'             => '/assets/images/products/lufly_146_1620-111-a.jpg',
        'designer-washbasins'                   => '/assets/images/products/lufly_205_ESINO.jpg',
        'luxury-ceramic-bidets'                 => '/assets/images/products/lufly_167_1650-081.jpg',
        'architectural-washbasin-mixers'        => '/assets/images/products/lufly_2115_1654-002.jpg',
        'kitchen-utility-mixers'                => '/assets/images/products/lufly_2189_1623-001.jpg',
        'thermostatic-shower-systems'           => '/assets/images/products/lufly_2109_1654-001.jpg',
        'touchless-sensor-systems'              => '/assets/images/products/lufly_2602_Screenshot-2025-12-01-232527.png',
        'barrier-free-accessible-sanitary-ware' => '/assets/images/products/lufly_2637_Screenshot-2025-12-22-151140.png',
        'commercial-urinal-systems'             => '/assets/images/products/lufly_3030_Screenshot-2026-07-22-174522.png',
        'sanitary-fittings-accessories'         => '/assets/images/products/lufly_2606_Screenshot-2025-12-01-234724.png',
        'actuator-plates-flush-systems'         => '/assets/images/products/lufly_2103_1685-011.jpg',
        'pedestals-ceramic-shrouds'             => '/assets/images/products/lufly_181_1660-140.jpg',
        'toilet-seats-accessories'              => '/assets/images/products/lufly_156_1620-111.jpg',
        'architectural-sanitary-ceramics'       => '/assets/images/products/lufly_268_1695-209-b.jpg',
    ];

    public static function localize(array $c, ?string $locale = null): array
    {
        $loc = $locale ?? I18n::getLocale();
        $c['name'] = $c['name_' . $loc] ?? $c['name_tr'] ?? $c['name'];
        $c['description'] = $c['description_' . $loc] ?? $c['description_tr'] ?? $c['description'];
        $c['thumbnail'] = self::CATEGORY_THUMBNAILS[$c['slug']] ?? $c['fallback_image'] ?? '/assets/images/brand/placeholder.png';
        return $c;
    }

    public static function localizeList(array $categories, ?string $locale = null): array
    {
        return array_map(fn($c) => self::localize($c, $locale), $categories);
    }

    public function getAllActive(): array
    {
        $loc = I18n::getLocale();
        $nameCol = "name_{$loc}";
        $sql = "SELECT c.*,
                       (SELECT p.primary_image 
                        FROM products p 
                        WHERE p.category_id = c.id 
                          AND p.primary_image IS NOT NULL 
                          AND p.primary_image NOT LIKE '%placeholder%'
                        ORDER BY p.is_featured DESC, p.id ASC 
                        LIMIT 1) AS fallback_image
                FROM categories c 
                WHERE c.product_count > 0 
                ORDER BY c.product_count DESC, {$nameCol} ASC";
        return self::localizeList($this->fetchAll($sql));
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
        $res = $this->fetchOne($sql, ['slug' => $slug]);
        return $res ? self::localize($res) : null;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $res = $this->fetchOne($sql, ['id' => $id]);
        return $res ? self::localize($res) : null;
    }
}
