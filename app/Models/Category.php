<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Category
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO categories (name, description)
                VALUES (:name, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE categories
                SET name = :name,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}