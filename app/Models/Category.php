<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public function getAllActive(): array
    {
        $sql = "SELECT * FROM categories WHERE product_count > 0 ORDER BY product_count DESC, name ASC";
        return $this->fetchAll($sql);
    }

    public function findBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
        return $this->fetchOne($sql, ['slug' => $slug]);
    }

    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        return $this->fetchOne($sql, ['id' => $id]);
    }
}
