<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Product extends Model
{
    public function getFeatured(int $limit = 8): array
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_featured = 1 
                ORDER BY p.id ASC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.slug = :slug LIMIT 1";
        return $this->fetchOne($sql, ['slug' => $slug]);
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id LIMIT 1";
        return $this->fetchOne($sql, ['id' => $id]);
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
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
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

                $fallbackSql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
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

        return $related;
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
            $conditions[] = "(p.name LIKE :search OR p.sku LIKE :search_sku OR p.description LIKE :search_desc)";
            $params['search'] = '%' . $filters['search'] . '%';
            $params['search_sku'] = '%' . $filters['search'] . '%';
            $params['search_desc'] = '%' . $filters['search'] . '%';
        }

        $orderBy = match ($sort) {
            'price-asc'  => 'p.price ASC, p.id ASC',
            'price-desc' => 'p.price DESC, p.id ASC',
            'sku-asc'    => 'p.sku ASC',
            'name-asc'   => 'p.name ASC',
            default      => 'p.is_featured DESC, p.id ASC',
        };

        $where = implode(' AND ', $conditions);
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
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
        return $stmt->fetchAll();
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
            $conditions[] = "(p.name LIKE :search OR p.sku LIKE :search_sku OR p.description LIKE :search_desc)";
            $params['search'] = '%' . $filters['search'] . '%';
            $params['search_sku'] = '%' . $filters['search'] . '%';
            $params['search_desc'] = '%' . $filters['search'] . '%';
        }

        $where = implode(' AND ', $conditions);
        $sql = "SELECT COUNT(*) as cnt FROM products p WHERE {$where}";
        $res = $this->fetchOne($sql, $params);
        return (int)($res['cnt'] ?? 0);
    }

    public function search(string $term, int $limit = 50): array
    {
        $wild = '%' . trim($term) . '%';
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.sku LIKE :q1 OR p.name LIKE :q2 OR p.description LIKE :q3 OR c.name LIKE :q4
                ORDER BY (CASE WHEN p.sku LIKE :q1 THEN 1 WHEN p.name LIKE :q2 THEN 2 ELSE 3 END), p.id ASC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':q1', $wild);
        $stmt->bindValue(':q2', $wild);
        $stmt->bindValue(':q3', $wild);
        $stmt->bindValue(':q4', $wild);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
