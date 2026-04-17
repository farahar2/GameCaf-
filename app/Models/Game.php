<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Game
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT games.*, categories.name AS category_name
                FROM games
                LEFT JOIN categories ON games.category_id = categories.id
                ORDER BY games.created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT games.*, categories.name AS category_name
                FROM games
                LEFT JOIN categories ON games.category_id = categories.id
                WHERE games.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function getByCategory(int $categoryId): array
    {
        $sql = "SELECT games.*, categories.name AS category_name
                FROM games
                LEFT JOIN categories ON games.category_id = categories.id
                WHERE games.category_id = :category_id
                ORDER BY games.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll();
    }

    public function search(string $keyword): array
    {
        $sql = "SELECT games.*, categories.name AS category_name
                FROM games
                LEFT JOIN categories ON games.category_id = categories.id
                WHERE games.name LIKE :keyword
                   OR games.description LIKE :keyword
                ORDER BY games.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO games 
                (category_id, name, description, min_players, max_players, duration, difficulty, stock, image_url, is_available)
                VALUES
                (:category_id, :name, :description, :min_players, :max_players, :duration, :difficulty, :stock, :image_url, :is_available)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'category_id'  => $data['category_id'],
            'name'         => $data['name'],
            'description'  => $data['description'],
            'min_players'  => $data['min_players'],
            'max_players'  => $data['max_players'],
            'duration'     => $data['duration'],
            'difficulty'   => $data['difficulty'],
            'stock'        => $data['stock'],
            'image_url'    => $data['image_url'],
            'is_available' => $data['is_available'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE games SET
                    category_id = :category_id,
                    name = :name,
                    description = :description,
                    min_players = :min_players,
                    max_players = :max_players,
                    duration = :duration,
                    difficulty = :difficulty,
                    stock = :stock,
                    image_url = :image_url,
                    is_available = :is_available
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id'           => $id,
            'category_id'  => $data['category_id'],
            'name'         => $data['name'],
            'description'  => $data['description'],
            'min_players'  => $data['min_players'],
            'max_players'  => $data['max_players'],
            'duration'     => $data['duration'],
            'difficulty'   => $data['difficulty'],
            'stock'        => $data['stock'],
            'image_url'    => $data['image_url'],
            'is_available' => $data['is_available'],
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM games WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
    public function countAvailable(): int
{
    $sql    = "SELECT COUNT(*) as total 
               FROM games 
               WHERE is_available = true";
    $stmt   = $this->db->query($sql); 
    $result = $stmt->fetch();
    return (int) $result['total'];
}
}