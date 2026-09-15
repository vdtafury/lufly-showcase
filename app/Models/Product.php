<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Helpers\I18n;
use PDO;

class Product extends Model
{
    public static function localize(array $p, ?string $locale = null): array
    {
        $loc = $locale ?? I18n::getLocale();
        $p['name'] = $p['name_' . $loc] ?? $p['name_tr'] ?? $p['name'];
        $p['category_name'] = $p['category_name_' . $loc] ?? $p['category_name_tr'] ?? $p['category_name'];
        $p['short_description'] = $p['short_description_' . $loc] ?? $p['short_description_tr'] ?? $p['short_description'];
        $p['description'] = $p['description_' . $loc] ?? $p['description_tr'] ?? $p['description'];
        $p['material'] = $p['material_' . $loc] ?? $p['material_tr'] ?? $p['material'];
        $p['mounting_type'] = $p['mounting_type_' . $loc] ?? $p['mounting_type_tr'] ?? $p['mounting_type'];
        $p['finish'] = $p['finish_' . $loc] ?? $p['finish_tr'] ?? $p['finish'];
        $p['warranty'] = $p['warranty_' . $loc] ?? $p['warranty_tr'] ?? $p['warranty'];
        $p['standards'] = $p['standards_' . $loc] ?? $p['standards_tr'] ?? $p['standards'];
        return $p;
    }

    public static function localizeList(array $products, ?string $locale = null): array
    {
        return array_map(fn($p) => self::localize($p, $locale), $products);
    }

    public function getFeatured(int $limit = 8): array
    {
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_featured = 1 
                ORDER BY p.id ASC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return self::localizeList($stmt->fetchAll());
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = :slug LIMIT 1";
        $res = $this->fetchOne($sql, ['slug' => $slug]);
        return $res ? self::localize($res) : null;
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id LIMIT 1";
        $res = $this->fetchOne($sql, ['id' => $id]);
        return $res ? self::localize($res) : null;
    }

    public function getGalleryImages(int $productId): array
    {
        $sql = "SELECT image_url, is_primary, sort_order 
                FROM product_images 
                WHERE product_id = :pid 
                ORDER BY sort_order ASC, is_primary DESC";
        return $this->fetchAll($sql, ['pid' => $productId]);
    }

    public function getRelated(int $productId, int $limit = 4): array
    {
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM product_relations pr
                JOIN products p ON pr.related_product_id = p.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE pr.product_id = :pid
                GROUP BY p.id
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':pid', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $related = $stmt->fetchAll();

        // If relations are fewer than limit, fetch siblings from same category
        if (count($related) < $limit) {
            $prod = $this->findById($productId);
            if ($prod) {
                $needed = $limit - count($related);
                $existingIds = array_column($related, 'id');
                $existingIds[] = $productId;
                $inClause = implode(',', array_fill(0, count($existingIds), '?'));

                $fallbackSql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                                FROM products p 
                                LEFT JOIN categories c ON p.category_id = c.id 
                                WHERE p.category_id = ? AND p.id NOT IN ($inClause) 
                                LIMIT ?";
                $params = array_merge([$prod['category_id']], $existingIds, [$needed]);
                $stmt2 = $this->db->prepare($fallbackSql);
                $stmt2->execute($params);
                $siblings = $stmt2->fetchAll();
                $related = array_merge($related, $siblings);
            }
        }

        return self::localizeList($related);
    }

    public function getList(array $filters = [], int $limit = 24, int $offset = 0, string $sort = 'default'): array
    {
        $conditions = ["1=1"];
        $params = [];

        if (!empty($filters['category_id'])) {
            $conditions[] = "p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['stock_status'])) {
            $conditions[] = "p.stock_status = :stock_status";
            $params['stock_status'] = $filters['stock_status'];
        }

        if (!empty($filters['search'])) {
            $conditions[] = "(p.sku LIKE :search OR p.name_tr LIKE :search OR p.name_en LIKE :search OR p.name_cs LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $loc = I18n::getLocale();
        $nameCol = "p.name_{$loc}";

        $orderBy = match ($sort) {
            'price-asc'  => 'p.price ASC, p.id ASC',
            'price-desc' => 'p.price DESC, p.id ASC',
            'sku-asc'    => 'p.sku ASC',
            'name-asc'   => "{$nameCol} ASC",
            default      => 'p.is_featured DESC, p.id ASC',
        };

        $where = implode(' AND ', $conditions);
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE {$where} 
                ORDER BY {$orderBy} 
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return self::localizeList($stmt->fetchAll());
    }

    public function countList(array $filters = []): int
    {
        $conditions = ["1=1"];
        $params = [];

        if (!empty($filters['category_id'])) {
            $conditions[] = "p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['stock_status'])) {
            $conditions[] = "p.stock_status = :stock_status";
            $params['stock_status'] = $filters['stock_status'];
        }

        if (!empty($filters['search'])) {
            $conditions[] = "(p.sku LIKE :search OR p.name_tr LIKE :search OR p.name_en LIKE :search OR p.name_cs LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $where = implode(' AND ', $conditions);
        $sql = "SELECT COUNT(*) as cnt FROM products p WHERE {$where}";
        $res = $this->fetchOne($sql, $params);
        return (int)($res['cnt'] ?? 0);
    }

    public function search(string $term, int $limit = 50): array
    {
        $wild = '%' . trim($term) . '%';
        $sql = "SELECT p.*, c.name as category_name, c.name_tr as category_name_tr, c.name_en as category_name_en, c.name_cs as category_name_cs, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.sku LIKE :q1 
                   OR p.name_tr LIKE :q2 OR p.name_en LIKE :q2 OR p.name_cs LIKE :q2
                   OR p.description_tr LIKE :q3 OR p.description_en LIKE :q3 OR p.description_cs LIKE :q3
                   OR c.name_tr LIKE :q4 OR c.name_en LIKE :q4 OR c.name_cs LIKE :q4
                ORDER BY (CASE WHEN p.sku LIKE :q1 THEN 1 WHEN p.name_tr LIKE :q2 OR p.name_en LIKE :q2 THEN 2 ELSE 3 END), p.id ASC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':q1', $wild);
        $stmt->bindValue(':q2', $wild);
        $stmt->bindValue(':q3', $wild);
        $stmt->bindValue(':q4', $wild);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return self::localizeList($stmt->fetchAll());
    }
}
