<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Inquiry extends Model
{
    public function create(array $data): int
    {
        $sql = "INSERT INTO inquiries (company_name, contact_name, email, phone, country, product_sku, product_name, inquiry_type, message, status, created_at)
                VALUES (:company_name, :contact_name, :email, :phone, :country, :product_sku, :product_name, :inquiry_type, :message, 'pending', datetime('now'))";
        
        $this->execute($sql, [
            'company_name' => $data['company_name'] ?? '',
            'contact_name' => $data['contact_name'] ?? '',
            'email'        => $data['email'] ?? '',
            'phone'        => $data['phone'] ?? '',
            'country'      => $data['country'] ?? '',
            'product_sku'  => $data['product_sku'] ?? '',
            'product_name' => $data['product_name'] ?? '',
            'inquiry_type' => $data['inquiry_type'] ?? 'quote',
            'message'      => $data['message'] ?? '',
        ]);

        return $this->lastInsertId();
    }

    public function getAll(int $limit = 50): array
    {
        $sql = "SELECT * FROM inquiries ORDER BY id DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
