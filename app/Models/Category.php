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

    // ============================================================
    // Basic getAll — no games count
    // Used in: GameController (for dropdowns in forms)
    // ============================================================
    public function getAll(): array
    {
        $sql  = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // ============================================================
    // getAll WITH games count
    // Used in: CategoryController::index()
    // ============================================================
    public function getAllWithCount(): array
    {
        $sql = "SELECT 
                    categories.*,
                    COUNT(games.id) AS games_count
                FROM categories
                LEFT JOIN games ON categories.id = games.category_id
                GROUP BY categories.id
                ORDER BY categories.name ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // ============================================================
    // Get ONE by id — simple
    // Used in: GameController forms
    // ============================================================
    public function getById(int $id): array|false
    {
        $sql  = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // ============================================================
    // Get ONE by id WITH games count
    // Used in: CategoryController::edit()
    // Why? To show if delete is allowed in the view
    // ============================================================
    public function getByIdWithCount(int $id): array|false
    {
        $sql = "SELECT 
                    categories.*,
                    COUNT(games.id) AS games_count
                FROM categories
                LEFT JOIN games ON categories.id = games.category_id
                WHERE categories.id = :id
                GROUP BY categories.id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // ============================================================
    // Create a new category
    // ============================================================
    public function create(array $data): bool
    {
        $sql = "INSERT INTO categories (name, description)
                VALUES (:name, :description)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    // ============================================================
    // Update a category
    // ============================================================
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE categories
                SET name        = :name,
                    description = :description
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'          => $id,
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }

    // ============================================================
    // Delete a category
    // Returns FALSE if category has games (FOREIGN KEY RESTRICT)
    // ============================================================
    public function delete(int $id): bool
    {
        try {
            $sql  = "DELETE FROM categories WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);

        } catch (\PDOException $e) {
            // MySQL error 1451 = foreign key constraint violation
            // Means: games are still using this category
            error_log("Cannot delete category $id: " . $e->getMessage());
            return false;
        }
    }

    // ============================================================
    // Check if a category name already exists
    // Used in: Validation before create/update
    // ============================================================
    public function nameExists(string $name, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql  = "SELECT COUNT(*) as total 
                     FROM categories 
                     WHERE name = :name AND id != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name, 'id' => $excludeId]);
        } else {
            $sql  = "SELECT COUNT(*) as total 
                     FROM categories 
                     WHERE name = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $name]);
        }

        $result = $stmt->fetch();
        return (int) $result['total'] > 0;
    }
}