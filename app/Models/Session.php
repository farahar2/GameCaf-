<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Session {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    //Démarrer une session
    public function start(int $reservationId, int $gameId, int $tableId, int $adminId): bool {
        $sql = "INSERT INTO sessions (reservation_id, game_id, table_id, started_by, start_time, status) 
                VALUES (:res_id, :game_id, :table_id, :admin_id, NOW(), 'in_progress')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'res_id'   => $reservationId,
            'game_id'  => $gameId,
            'table_id' => $tableId,
            'admin_id' => $adminId
        ]);
    }

    //Dashboard des sessions actives
    public function getActiveSessions(): array {
        $sql = "SELECT s.*, g.name AS game_name, t.table_number, u.name AS client_name
                FROM sessions s
                JOIN games g ON s.game_id = g.id
                JOIN caftables t ON s.table_id = t.id
                JOIN reservations r ON s.reservation_id = r.id
                JOIN users u ON r.user_id = u.id
                WHERE s.status = 'in_progress'
                ORDER BY s.start_time DESC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    //Terminer une session
    public function finish(int $id): bool {
        $sql = "UPDATE sessions 
                SET end_time = NOW(), 
                    status = 'completed',
                    duration = TIMESTAMPDIFF(MINUTE, start_time, NOW()) 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    //Historique complet
    public function getHistory(): array {
        $sql = "SELECT s.*, g.name AS game_name, t.table_number, admin_u.name AS admin_name
                FROM sessions s
                JOIN games g ON s.game_id = g.id
                JOIN caftables t ON s.table_id = t.id
                LEFT JOIN users admin_u ON s.started_by = admin_u.id
                ORDER BY s.start_time DESC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}