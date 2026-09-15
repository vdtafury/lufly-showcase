<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Helpers\I18n;

class Category extends Model
{
    public static function localize(array $c, ?string $locale = null): array
    {
        $loc = $locale ?? I18n::getLocale();
        $c['name'] = $c['name_' . $loc] ?? $c['name_tr'] ?? $c['name'];
        $c['description'] = $c['description_' . $loc] ?? $c['description_tr'] ?? $c['description'];
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
        $sql = "SELECT * FROM categories WHERE product_count > 0 ORDER BY product_count DESC, {$nameCol} ASC";
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
