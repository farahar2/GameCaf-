<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Table
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    //ALL tables
    public function getAll(): array
    {
        $sql  = "SELECT * FROM caftables ORDER BY table_number ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    //AVAILABLE tables
    public function getAvailable(): array
    {
        $sql  = "SELECT * FROM caftables 
                 WHERE is_available = true 
                 ORDER BY table_number ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Get ONE table by id
    public function getById(int $id): array|false
    {
        $sql  = "SELECT * FROM caftables WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    //Update table availability
    public function updateAvailability(int $id, bool $isAvailable): bool
    {
        $sql  = "UPDATE caftables 
                 SET is_available = :is_available 
                 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'           => $id,
            'is_available' => $isAvailable,
        ]);
    }
}